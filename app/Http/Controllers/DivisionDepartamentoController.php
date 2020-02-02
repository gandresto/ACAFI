<?php

namespace App\Http\Controllers;

use App\Division;
use App\Departamento;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DivisionDepartamentoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($division_id)
    {
        $division = Division::findOrFail($division_id);
        //$departamentos = Departamento::where('division_id','=', $division_id)->paginate(10);
        return view('divisions.departamentos.index', compact('division'));//, 'departamentos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($division_id)
    {
        $this->authorize('create', Division::class);
        $division = Division::findOrFail($division_id);
        return view('divisions.departamentos.create', compact('division'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($division_id, Request $request)
    {
        $this->authorize('create', Departamento::class);
        // dd($request->all());
        $data = request()->validate([
            'nombre' => 'required|unique:departamentos|max:50|string',
            'id_jefe_dpto' => 'required|exists:users,id',
            'fecha_ingreso' => 'max:128|date|before:'.Carbon::now(),
            //'division_id' => 'required|exists:divisions,id',
        ]);

        // dd([$data, $division_id]);
        $departamento = Departamento::create([
            'nombre' => $data['nombre'],
            'division_id' => $division_id,
        ]);

        $departamento->jefes()->attach($division_id, ['fecha_ingreso' => $data['fecha_ingreso']]);

        return redirect()->route('divisions.show', ['division' => $division_id])
                        ->with('success', 'Departamento con nombre \''
                                        . $data['nombre']
                                        .'\' creado satisfactoriamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($division_id, $dpto_id)
    {
        $division = Division::findOrFail($division_id);
        $departamento = Departamento::findOrFail($dpto_id);
        return view('divisions.departamentos.show', compact('division', 'departamento'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($division_id, $departamento_id)
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
    public function update(Request $request, $division_id, $departamento_id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $division_id
     * @param  int  $departamento_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($division_id, $departamento_id)
    {
        $departamento = Departamento::find($departamento_id);
        $this->authorize('delete', $departamento);
        //dd('Removiendo departamento '. $departamento_id);
        if ($departamento->academias->isEmpty()){
            $departamento->forceDelete();
            return redirect()->route('divisions.show', $division_id)
                        ->with('success', 'División eliminada.');
        } else{
            return redirect()->route('divisions.show', $division_id)
                        ->with('error', 'No se puede eliminar un departamento que aún tiene academias.');
        }
    }
}
