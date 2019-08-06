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
        $divisiones = Division::all();
        return view('division.index', compact('divisiones'));
    }

    public function show($division)
    {
        $division = Division::findOrFail($division);
        return view('division.show', compact('division'));
    }

    public function create()
    {
        #$this->middleware(AdminMiddleware::class);
        return view('division.create');
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
        $request->session()->flash('status', 'División con nombre \'' 
                                            . $request['nombre'] 
                                            .'\' creada satisfactoriamente.');
        return redirect('/division');
    }
}
