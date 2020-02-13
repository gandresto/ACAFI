<?php

namespace App\Http\Controllers;

use App\Reunion;
use App\Academia;
use Illuminate\Http\Request;

class AcademiaReunionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Academia  $academia
     * @return \Illuminate\Http\Response
     */
    public function index(Academia $academia)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Academia  $academia
     * @return \Illuminate\Http\Response
     */
    public function create(Academia $academia)
    {
        $this->authorize('crearReunion', $academia);
        return view('academias.reuniones.create', [ 'academia' => $academia ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Academia  $academia
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Academia $academia)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Academia  $academia
     * @param  \App\Reunion  $reunion
     * @return \Illuminate\Http\Response
     */
    public function show(Academia $academia, Reunion $reunion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Academia  $academia
     * @param  \App\Reunion  $reunion
     * @return \Illuminate\Http\Response
     */
    public function edit(Academia $academia, Reunion $reunion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Academia  $academia
     * @param  \App\Reunion  $reunion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Academia $academia, Reunion $reunion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Academia  $academia
     * @param  \App\Reunion  $reunion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Academia $academia, Reunion $reunion)
    {
        //
    }
}
