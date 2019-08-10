<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Division;
use App\Http\Middleware\AdminMiddleware;

class DivisionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $divisiones = Division::paginate(10);
        return view('divisions.index', compact('divisiones'));
    }

    public function show($division)
    {
        $division = Division::findOrFail($division);
        return view('divisions.show', compact('division'));
    }

    public function create()
    {
        $this->authorize('create', Division::class);
        return view('divisions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'siglas' => 'required|unique:divisions|max:10|string',
            'nombre' => 'required|unique:divisions|max:50|string',
            'id_jefe_div' => ['required', 'exists:academicos,id'],
        ]);

        Division::create($request->all());

        return redirect()->route('divisions.index')
                        ->with('success', 'División con nombre \''
                                        . $request['nombre']
                                        .'\' creada satisfactoriamente.');
    }

    public function edit(Division $division)
    {
        #dd($division);
        return view('divisions.edit', compact('division'));
    }

    public function update(Request $request, Division $division)
    {
        $request->validate([
            'siglas' => 'required|unique:divisions|max:10|string',
            'nombre' => 'required|unique:divisions|max:50|string',
            'id_jefe_div' => ['required', 'exists:academicos,id'],
        ]);

        $division->update($request->all());

        return redirect()->route('divisions.index')
                        ->with('success', 'División con nombre \''
                                        . $request->data['nombre']
                                        .'\' actualizada satisfactoriamente.');
    }

    public function destroy(int $id)
    {
        Division::destroy($id);
        return redirect()->route('divisions.index')
                        ->with('success', 'División con eliminada.');
    }
}
