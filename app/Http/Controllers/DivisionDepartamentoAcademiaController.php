<?php

namespace App\Http\Controllers;

use App\Academia;
use App\Departamento;
use App\Division;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DivisionDepartamentoAcademiaController extends Controller
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
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($division_id, $departamento_id)
    {
        $division = Division::findOrFail($division_id);
        $departamento = $division->departamentos()->findOrFail($departamento_id);
        return view('divisions.departamentos.academias.create', compact(['division', 'departamento']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($division_id, $departamento_id, Request $request)
    {

        $this->authorize('create', Academia::class);
        $data = request()->validate(
            [
                'nombre' => 'required|unique:divisions|max:50|string',
                'fecha_ingreso' => 'max:128|date|before:'.Carbon::now(),
                'presidente_id' => 'required|exists:users,id',
            ]
        );

        // dd($data, $division_id, $departamento_id);

        $academia = Academia::create([
            'nombre' => $data['nombre'],
            'departamento_id' => $departamento_id,
        ]);

        $academia->presidentes()->attach($data['presidente_id'], ['fecha_ingreso' => $data['fecha_ingreso']]);

        return redirect()->route('divisions.departamentos.show', compact('division_id', 'departamento_id'))
                        ->with('success', 'Academia \''. $data['nombre']
                                        .'\' creada satisfactoriamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($division_id, $departamento_id, $academia_id)
    {
        $division = Division::findOrFail($division_id);
        $departamento = $division->departamentos()->findOrFail($departamento_id);
        $academia = $departamento->academias()->findOrFail($academia_id);
        // dd(compact(['division', 'departamento', 'academia']));
        return view('divisions.departamentos.academias.show', compact(['division', 'departamento', 'academia']));
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
    public function destroy($division_id, $departamento_id, $academia_id)
    {
        $academia = Academia::find($academia_id);
        $this->authorize('delete', $academia);

        if ($academia->miembros->isEmpty()){
            $academia->forceDelete();
            return redirect()->route('divisions.departamentos.show', compact('division_id', 'departamento_id'))
                        ->with('success', 'Academia eliminada.');
        } else{
            return redirect()->route('divisions.departamentos.show', compact('division_id', 'departamento_id'))
                        ->with('error', 'No se puede eliminar una academia que aún tiene miembros.');
        }
    }

    public function darDeBajaMiembro($division_id, $departamento_id, $academia_id, $miembro_id)
    {
        $academia = Academia::find($academia_id);
        $this->authorize('darDeBajaCualquierMiembro', $academia);
        // dd($academia);
        $academia->miembros()->updateExistingPivot($miembro_id, ['fecha_egreso' => Carbon::now()]);
        // dd($academia->miembros()->wherePivot('fecha_egreso', '=', null)
        //                         ->where('miembro_id', '=', $miembro_id)
        //                         ->get());//->whereupdateExistingPivot($miembro_id, ['fecha_egreso' => Carbon::now()]);
        return redirect()->route('divisions.departamentos.academias.show', compact('division_id', 'departamento_id', 'academia_id'))
                        ->with('success', 'Miembro dado de baja.');
    }

    public function agregarMiembro($division_id, $departamento_id, $academia_id)
    {
        $division = Division::findOrFail($division_id);
        $departamento = $division->departamentos()->findOrFail($departamento_id);
        $academia = $departamento->academias()->findOrFail($academia_id);
        return view('divisions.departamentos.academias.agregar-miembro', compact('division', 'departamento', 'academia'));
    }
}
