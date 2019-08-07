<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Academico;
use Illuminate\Support\Facades\Session;

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

        $data = request()->validate([
            'grado_id' => 'required|max:8|string|exists:grados,id',
            'nombre' => 'required|max:50|string',
            'apellido_pat' => 'required|max:50|string',
            'apellido_mat' => 'required|max:50|string',
        ]);

        Academico::create([
            'grado_id' => $data['grado_id'],
            'nombre' => $data['nombre'],
            'apellido_pat' => $data['apellido_pat'],
            'apellido_mat' => $data['apellido_mat'],
        ]);

        $request->session()->flash('status', 'Académico con nombre \''
                                                . $data['nombre']
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
    public function destroy(int $id)
    {
        //dd($id);
        $academico = Academico::find($id);
        if($academico->user && $academico->user->email == config('admin.email')){
            return redirect()->route('academicos.index')
                            ->with('error', 'No se puede borrar este registro.');
        }else{
            $academico->delete();
            return redirect()->route('academicos.index')
                            ->with('success', 'El academico fue borrado satisfactoriamente.');
        }
    }
}
