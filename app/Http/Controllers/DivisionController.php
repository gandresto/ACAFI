<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Division;
use App\Http\Middleware\AdminMiddleware;
use Carbon\Carbon as Carbon;

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
        $this->authorize('create', Division::class);
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

        return redirect()->route('divisions.index')
                        ->with('success', 'División con nombre \''
                                        . $data['nombre']
                                        .'\' creada satisfactoriamente.');
    }

    public function edit(Division $division)
    {
        $this->authorize('update', $division);
        return view('divisions.edit', compact('division'));
    }

    public function update(Request $request, Division $division)
    {
        $this->authorize('update', $division);
        $data = request()->validate([
            'siglas' => 'required|max:10|string|unique:divisions,siglas,'.$division->id,
            'nombre' => 'required|max:50|string|unique:divisions,nombre,'.$division->id,
            'id_jefe_div' => ['required', 'exists:academicos,id'],
        ]);

        dd($data);

        $division->update($data);

        return redirect()->route('divisions.index')
                        ->with('success', 'División con nombre \''
                                        . $data['nombre']
                                        .'\' actualizada satisfactoriamente.');
    }

    public function destroy(int $id)
    {
        $division = Division::find($id);
        $this->authorize('delete', $division);

        if ($division->departamentos->isEmpty()){
            $division->delete();
            return redirect()->route('divisions.index')
                        ->with('success', 'División eliminada.');
        } else{
            return redirect()->route('divisions.index')
                        ->with('error', 'No se puede eliminar una división que aún tiene departamentos.');
        }


    }

    public function buscar($busqueda)
    {
        $busqueda = urldecode($busqueda);
        $divisiones = Division::where('nombre', 'like', '%' . $busqueda . '%')
                            ->orWhere('siglas', 'like', '%' . $busqueda . '%')
                            ->orderBy('nombre', 'desc')
                            ->limit(5)
                            ->get();

        return response()->json($divisiones);
    }


}
