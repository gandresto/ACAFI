<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Http\Resources\UserResource;
use App\Http\Resources\AcademiasCollection;
use App\Http\Resources\ReunionResource;
use App\Notifications\AvisoUsuarioCreado;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $q = $request->input('q');
        $limit = $request->input('limit', 5);
        if( $q ){
            return Cache::remember("user.buscar?q={$q}&limit={$limit}", now()->addSeconds(30), function () use ($q, $limit){
                // Si la cadena a buscar es menor o igual a 2 caracteres, devuelve una colección vacia
                $users = strlen($q) > 2 ? User::buscar($q, $limit)->get() : collect([]);
                // Si no encuentra usuarios, devuelve un error 404
                return $users->isNotEmpty() ? UserResource::collection($users) : response(['message' => 'No se encontró ningún usuario con los criterios de búsqueda'], 404);
            });
        }
        return UserResource::collection(User::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', User::class);
        $data = request()->validate(
            [
                'email' => 'required|string|email|max:50|unique:users',
                'password' => 'required|string|min:6|confirmed',
                'grado' => 'required|max:8|string',
                'nombre' => 'required|max:50|string',
                'apellido_paterno' => 'required|max:50|string',
                'apellido_materno' => 'required|max:50|string'
            ]
        );
        $user = User::create($data);
        $user->rollApiKey();
        $user->notify(new AvisoUsuarioCreado(['rawPass' => $data['password']])); // Avisamos al usuario por correo

        return response([
            'usuario_creado' => new UserResource($user),
            'message' => 'Usuario creado safisfactoriamente',
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function academiasQueHaPresidido(Request $request, int $user_id)
    {
        $user = User::findOrFail($user_id);
        $actual = $request->input('actual');
        if($actual && ($actual=="true" || $actual==1))
            return new AcademiasCollection($user->academiasQuePreside->sortBy('nombre'));
        return new AcademiasCollection($user->academiasQueHaPresidido->sortBy('nombre'));
    }

    public function yo(Request $request)
    {
        // return json_encode(['mensaje'=> 'yo mero :D']);
        return new UserResource(Auth::user());
    }

    public function reuniones(int $user_id)
    {
        return ReunionResource::collection(User::findOrFail($user_id)->reuniones);
    }
}
