<?php

namespace App\Http\Controllers\Api;

use Illuminate\Validation\Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Division;
use App\Http\Resources\DivisionResource;
use App\Http\Resources\DivisionsCollection;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $divisiones = Division::all();
        return new DivisionsCollection($divisiones);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Division::class);
        /*
        $data = $request->all();
        $validator = Validator::make($data, [
            [
                'siglas' => 'required|unique:divisions|max:10|string',
                'nombre' => 'required|unique:divisions|max:50|string',
                'url' => 'required|max:128|url',
                'fecha_ingreso' => 'max:128|date|before:'.Carbon::now(),
                'id_jefe_div' => 'required|exists:users,id',
            ]
        ]);
        */
        $data = request()->validate(
            [
                'siglas' => 'required|unique:divisions|max:10|string',
                'nombre' => 'required|unique:divisions|max:50|string',
                'url' => 'required|max:128|url',
                'fecha_ingreso' => 'max:128|date|before:'.Carbon::now(),
                'id_jefe_div' => 'required|exists:users,id',
            ]
        );

        $division = Division::create([
            'siglas' => $data['siglas'],
            'nombre' => $data['nombre'],
            'url' => $data['url'],
        ]);

        $division->jefes()->attach($data['id_jefe_div'], ['fecha_ingreso' => $data['fecha_ingreso']]);
        return new DivisionResource($division);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $division = Division::findOrFail($id);
        return response()->json($division);
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
        return response()->json(['Nombre de la página' => "Editar division {$id}"]);
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
        $divisiones = Division::where('nombre', 'like', '%' . $consulta . '%')
                            ->orWhere('siglas', 'like', '%' . $consulta . '%')
                            ->orderBy('nombre', 'desc')
                            ->limit(5)
                            ->get();

        return new DivisionResource($divisiones);
    }
}
