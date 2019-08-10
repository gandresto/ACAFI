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
        $divisiones = Division::paginate(5);
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
        $this->validate($request, [
            'siglas' => 'required|unique:divisions|max:255|string',
            'nombre' => 'required|unique:divisions|max:255|string',
            'jefeDeDivision' => ['required', 'exists:academicos,id'],
        ]);

        #dd($request['jefeDeDivision']);

        Division::create([
            'id_jefe_div' => $request['jefeDeDivision'],
            'siglas' => $request['siglas'],
            'nombre' => $request['nombre'],
        ]);

        return redirect()->route('divisions.index')
                        ->with('success', 'División con nombre \''
                                        . $request['nombre']
                                        .'\' creada satisfactoriamente.');
    }

    public function edit(Division $division)
    {
        return view('divisions.edit', compact('division'));
    }

    public function update(Request $request, Division $division)
    {
        dd($division);
    }

    public function destroy(int $id)
    {
        # code...
    }
}
