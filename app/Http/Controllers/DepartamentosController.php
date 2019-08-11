<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Departamento;

class DepartamentosController extends Controller
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
        $departamentos = Departamento::paginate(10);
        return view('departamentos.index', compact('departamentos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Departamento::class);
        return view('departamentos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Departamento::class);
        $request->validate([
            'nombre' => 'required|unique:departamentos|max:50|string',
            'id_jefe_dpto' => 'required|exists:academicos,id',
            'division_id' => 'required|exists:divisions,id',
        ]);

        Departamento::create($request->all());

        return redirect()->route('departamentos.index')
                        ->with('success', 'Departamento con nombre \''
                                        . $request['nombre']
                                        .'\' creado satisfactoriamente.');
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

    public function buscar($busqueda)
    {
        $busqueda = urldecode($busqueda);
    
        $departamentos = Departamento::where('nombre', 'like', '%' . $busqueda . '%')
                            ->orderBy('nombre', 'desc')
                            ->limit(5)
                            ->get();
        
        return response()->json($departamentos);
    }
}
