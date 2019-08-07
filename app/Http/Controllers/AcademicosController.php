<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Academico;

class AcademicosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Academico $academicos)
    {
        $academicos = Academico::all();
        return view('academicos.index', compact('academicos'));
    }

    public function show(Academico $academico)
    {
        return response()->json($academico);
    }

    public function create()
    {
        return view('academicos.create');
    }

    public function registrar()
    {
        return view('academicos.registrar');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'grado_id' => 'required|max:8|string|exists:grados,id',
            'nombre' => 'required|max:255|string',
            'apellido_pat' => 'required|max:255|string',
            'apellido_mat' => 'required|max:255|string',
        ]);

        #dd($request);

        Academico::create([
            'grado_id' => $request['grado_id'],
            'nombre' => $request['nombre'],
            'apellido_pat' => $request['apellido_pat'],
            'apellido_mat' => $request['apellido_mat'],
        ]);

        $request->session()->flash('status', 'Académico con nombre \''
                                                . $request['nombre']
                                                .'\' creado satisfactoriamente.');

        return redirect(route('academicos.index'));
    }

    public function buscar($busqueda)
    {
        $busqueda = urldecode($busqueda);
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");
        if ($driver == 'sqlite') {
            $academicos = Academico::orWhereRaw("nombre || ' ' || apellido_pat || ' ' || apellido_mat like '%" .
                                $busqueda . "%' ")
                                ->orderBy('nombre', 'desc')
                                ->limit(5)
                                ->get();
        } else {
            $academicos = Academico::orWhereRaw("concat(nombre, ' ', apellido_pat, ' ', apellido_mat) like '%" .
                                $busqueda . "%' ")
                                ->orderBy('nombre', 'desc')
                                ->limit(5)
                                ->get();
        }
        return response()->json($academicos);
    }
}
