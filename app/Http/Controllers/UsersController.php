<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Validator;

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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request()->validate(
            [
                'grado_id' => 'required|max:8|string|exists:grados,id',
                'nombre' => 'required|max:50|string',
                'apellido_pat' => 'required|max:50|string',
                'apellido_mat' => 'required|max:50|string',
                'email' => 'required|string|email|max:50|unique:users',
                'password' => 'required|string|min:6|confirmed',
            ]
        );

        dd($data);

/*         App\Academico::create([
            'nombre' => $data['nombre'],
            'apellido_pat' => $data['apellido_pat'],
            'apellido_mat' => $data['apellido_mat'],
        ]);
        $academico->nombre = $data['nombre'];
        $academico->apellido_pat = $data['apellido_pat'];
        $academico->apellido_mat = $data['apellido_mat'];
        $academico->grado_id = $data['grado_id'];
        $academico->user()->create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        $academico->push(); */
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
}
