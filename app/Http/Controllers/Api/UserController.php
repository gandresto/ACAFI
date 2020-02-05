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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
    public function show($id)
    {
        return new UserResource(User::findOrFail($id));
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

    public function buscar($consulta)
    {
        $consulta = urldecode($consulta);
        return Cache::remember('user.buscar.'.$consulta, now()->addSeconds(30), function () use ($consulta){
            $connection = config('database.default');
            $driver = config("database.connections.{$connection}.driver");
            if ($driver == 'sqlite') {
                $users = User::where("email", "LIKE", "%". $consulta . "%")
                                    ->orWhereRaw("nombre || ' ' || apellido_paterno || ' ' || apellido_materno LIKE '%" . $consulta . "%' ")
                                    ->orderBy('nombre', 'desc')
                                    ->limit(5)
                                    ->get();
            } else {
                $users = User::where("email", 'LIKE', "%". $consulta . "%")
                                    ->orWhereRaw("CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) LIKE '%" . $consulta . "%' ")
                                    ->orderBy('nombre', 'desc')
                                    ->limit(5)
                                    ->get();
            }
            // dd($users);
            return $users->isNotEmpty() ? UserResource::collection($users) : response()->json(['message' => 'No se encontró ningún usuario con los criterios de búsqueda'], 404);
        });
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
