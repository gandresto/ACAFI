<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");
        if ($driver == 'sqlite') {
            $users = User::where("email", "like", "%". $consulta . "%")
                                ->orWhereRaw("nombre || ' ' || apellido_pat || ' ' || apellido_mat like '%" . $consulta . "%' ")
                                ->orderBy('nombre', 'desc')
                                ->limit(5)
                                ->get();
        } else {
            $users = User::where("email", 'like', "%". $consulta . "%")
                                ->orWhereRaw("concat(nombre, ' ', apellido_pat, ' ', apellido_mat) like '%" . $consulta . "%' ")
                                ->orderBy('nombre', 'desc')
                                ->limit(5)
                                ->get();
        }
        return response()->json($users);
    }
}
