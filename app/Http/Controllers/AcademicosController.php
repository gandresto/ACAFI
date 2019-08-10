<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Academico;
use Illuminate\Support\Facades\Session;
use App\User;

class AcademicosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Academico $academicos)
    {
        $academicos = Academico::paginate(10);
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
            'email' => 'required|string|email|max:50|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $academico = new Academico;
        $academico->nombre = $data['nombre'];
        $academico->apellido_pat = $data['apellido_pat'];
        $academico->apellido_mat = $data['apellido_mat'];
        $academico->grado_id = $data['grado_id'];
        $academico->push();

        User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'academico_id' => $academico->id,
        ]);

        return redirect(route('academicos.index'))
                        ->with('success', 'Académico con nombre \''
                        . $data['nombre']
                        .'\' creado satisfactoriamente.');
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

    public function edit(Academico $academico)
    {
        $this->authorize('update', $academico);
        return view('academicos.edit', compact('academico'));
    }

    public function update(Request $request, Academico $academico)
    {
        $this->authorize('update', $academico);

        $data = request()->validate([
            'grado_id' => 'required|max:8|string|exists:grados,id',
            'nombre' => 'required|max:50|string',
            'apellido_pat' => 'required|max:50|string',
            'apellido_mat' => 'required|max:50|string',
            'email' => 'required|string|email|max:50|unique:users',
        ]);

        $academico->update(
            [
                'grado_id' => $data['grado_id'],
                'nombre' => $data['nombre'],
                'apellido_pat' =>  $data['apellido_pat'],
                'apellido_mat' => $data['apellido_mat'],
            ]
        );

        $academico->user()->update(
            [
                'email' => $data['email'],
            ]
        );

        return redirect(route('academicos.index'))
                        ->with('success', 'Académico con nombre \''
                        . $data['nombre']
                        .'\' actualizado satisfactoriamente.');
    }
}
