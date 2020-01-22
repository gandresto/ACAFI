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
        // $this->authorize('viewAny', Reunion::class);
        // $reuniones = Auth::user()->reuniones;
        $user = Auth::user();
        $reunionesComoConvocado = $user->reunionesComoConvocado->sortBy('inicio')->filter(function ($reunion) {
            return Carbon::createFromFormat('Y-m-d H:i:s', 
                                            $reunion->fin, 
                                            config('app.timezone'))
                                            ->isAfter(Carbon::now());
        });
        $reunionesComoInvitadoExterno = $user->reunionesComoInvitadoExterno->sortBy('inicio')->filter(function ($reunion) {
            return Carbon::createFromFormat('Y-m-d H:i:s', 
                                            $reunion->fin, 
                                            config('app.timezone'))
                                            ->isAfter(Carbon::now());
        });
        $reunionesComoPresidente = $user->reunionesComoPresidente->sortBy('inicio')->filter(function ($reunion) {
            return Carbon::createFromFormat('Y-m-d H:i:s', 
                                            $reunion->fin, 
                                            config('app.timezone'))
                                            ->isAfter(Carbon::now());
        });
        return view('reuniones.index', compact('reunionesComoConvocado', 'reunionesComoInvitadoExterno', 'reunionesComoPresidente'));
    }

    public function create(Request $request)
    {
        $this->authorize('create', Reunion::class);
        return view('reuniones.create');
    }
    
    public function descargarOrdenDelDia(int $id_reunion)
    {
        $reunion = Reunion::findOrFail($id_reunion);
        if(!$reunion->orden_del_dia) abort(404);
        else return response()->file(config('filesystems.disks.local.root')
                                        .DIRECTORY_SEPARATOR
                                        .$reunion->orden_del_dia
                                    );
    }
}
