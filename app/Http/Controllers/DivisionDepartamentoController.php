<?php

namespace App\Http\Controllers;

use App\Division;
use App\Departamento;
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
    public function index($id_division)
    {
        $division = Division::findOrFail($id_division);
        $departamentos = Departamento::where('id_division', $id_division)->paginate(10);// $division->departamentos::paginate(10);
        return view('divisions.departamentos.index', compact('division', 'departamentos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id_division)
    {
        $this->authorize('create', Division::class);
        $division = Division::findOrFail($id_division);
        return view('divisions.departamentos.create', compact('division'));
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
        dd($request);
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
    public function edit($id_division, $id_departamento)
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
    public function update(Request $request, $id_division, $id_departamento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id_division
     * @param  int  $id_departamento
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_division, $id_departamento)
    {
        //
    }
}
