<?php

namespace App\Http\Controllers;

use App\Reunion;
use Illuminate\Http\Request;

class ReunionesMinutasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request, int $reunion_id)
    {
        $reunion = Reunion::findOrFail($reunion_id);
        if (!$reunion->minuta) abort(404);
        else return response()->file(
            config('filesystems.disks.local.root')
                . DIRECTORY_SEPARATOR
                . $reunion->minuta
        );
    }

    public function create(Request $request, int $reunion_id)
    {
        $reunion = Reunion::findOrFail($reunion_id);
        $this->authorize('crearMinuta', $reunion);
        return view('reuniones.minuta.create', compact('reunion'));
    }
}
