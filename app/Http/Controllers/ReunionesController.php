<?php

namespace App\Http\Controllers;

use App\Reunion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReunionesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        // dd($request->query('minuta'));
        $quieroMinuta = esVerdadero($request->query('minuta'));
        $antesde = $request->query('antesde') ? Carbon::parse($request->query('antesde')) : null;
        $despuesde = $request->query('despuesde') ? Carbon::parse($request->query('despuesde')) : null;

        $reuniones = $user->reuniones
                            ->sortBy('inicio')
                            ->filter(function ($reunion) use ($quieroMinuta, $antesde, $despuesde) 
                            {
                                return ($quieroMinuta ? $reunion->minuta : $reunion->minuta == null)
                                        && ($antesde ? $antesde > $reunion->inicio : true)
                                        && ($despuesde ? $despuesde < $reunion->inicio : true);
                            });
        return view('reuniones.index', [
            'reuniones' => $reuniones,
            'minuta' => $request->query('minuta'),
            'antesde' => $request->query('antesde'),
            'despuesde' => $request->query('despuesde'),
        ]);
    }

    public function create(Request $request)
    {
        $this->authorize('create', Reunion::class);
        return view('reuniones.create');
    }

    public function show(int $reunion_id)
    {
        $reunion = Reunion::findOrFail($reunion_id);
        $this->authorize('view', $reunion);
        return view('reuniones.show', compact('reunion'));
    }

    public function descargarOrdenDelDia(int $id_reunion)
    {
        $reunion = Reunion::findOrFail($id_reunion);
        if (!$reunion->orden_del_dia) abort(404);
        else return response()->file(
            config('filesystems.disks.local.root')
                . DIRECTORY_SEPARATOR
                . $reunion->orden_del_dia
        );
    }
}
