<?php

namespace App\Http\Controllers;

use App\Reunion;
use Illuminate\Http\Request;

class ReunionesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        // $this->authorize('viewAny', Reunion::class);
        return view('reuniones.index');
    }

    public function create(Request $request)
    {
        $this->authorize('create', Reunion::class);
        return view('reuniones.create');
    }
}
