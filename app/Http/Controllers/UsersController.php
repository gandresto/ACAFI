<?php

namespace App\Http\Controllers;

use App\Notifications\AvisoUsuarioCreado;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Validator;
use App\User;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', User::class);
        return view('users.create');
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
        #dd($data);
        $user = User::create($data);
        $user->rollApiKey();
        $user->notify(new AvisoUsuarioCreado(['rawPass' => $data['password']])); // Avisamos al usuario por correo
            
        return redirect()->route('users.index')
                        ->with('success', 'Usuario con nombre ' . $user->nombre_completo . ' creado satisfactoriamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('view', $user);
        dd($user);        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        if($user->email == config('admin.email')){
            return redirect()->route('users.index')
                            ->with('error', 'Error: No está permitido editar este registro.');
        }
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
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
        $user = User::findOrFail($id);
        $this->authorize('update', $user); 
        $data = request()->validate([
            'grado' => 'required|max:8|string',
            'nombre' => 'required|max:50|string',
            'apellido_paterno' => 'required|max:50|string',
            'apellido_materno' => 'required|max:50|string',
            'email' => 'required|string|email|max:50|unique:users,email,'.$user->id,
        ]);

        $user->update(
            [
                'grado' => $data['grado'],
                'nombre' => $data['nombre'],
                'apellido_paterno' =>  $data['apellido_paterno'],
                'apellido_materno' => $data['apellido_materno'],
                'email' => $data['email'],
            ]
        );

        return redirect(route('users.index'))
                        ->with('success', 'Académico con nombre \''
                        . $data['nombre']
                        .'\' actualizado satisfactoriamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if($user->email == config('admin.email')){
            return redirect()->route('users.index')
                            ->with('error', 'Error: No está permitido borrar este registro.');
        }
    }

    public function buscar($consulta)
    {
        $consulta = urldecode($consulta);
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");
        if ($driver == 'sqlite') {
            $users = User::where("email", "like", "%". $consulta . "%")
                                ->orWhereRaw("nombre || ' ' || apellido_paterno || ' ' || apellido_materno like '%" . $consulta . "%' ")
                                ->orderBy('nombre', 'desc')
                                ->limit(5)
                                ->get();
        } else {
            $users = User::where("email", 'like', "%". $consulta . "%")
                                ->orWhereRaw("concat(nombre, ' ', apellido_paterno, ' ', apellido_materno) like '%" . $consulta . "%' ")
                                ->orderBy('nombre', 'desc')
                                ->limit(5)
                                ->get();
        }
        return response()->json($users);
    }
}
