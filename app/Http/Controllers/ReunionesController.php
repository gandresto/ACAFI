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
        $reuniones = $user->reuniones->sortBy('inicio')->filter(function ($reunion) {
            return Carbon::createFromFormat('Y-m-d H:i:s', 
                                            $reunion->fin, 
                                            config('app.timezone'))
                                            ->isAfter(Carbon::now());
        })->paginate(12);
        return view('reuniones.index', compact('reuniones'));
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
        if(!$reunion->orden_del_dia) abort(404);
        else return response()->file(config('filesystems.disks.local.root')
                                        .DIRECTORY_SEPARATOR
                                        .$reunion->orden_del_dia
                                    );
    }
}
