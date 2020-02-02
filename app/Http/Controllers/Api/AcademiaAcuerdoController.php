<?php

namespace App\Http\Controllers\Api;

use App\Academia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AcuerdoResource;

class AcademiaAcuerdoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, int $academia_id)
    {
        $academia = Academia::findOrFail($academia_id);
        $pendientes = $request->input('estadofin'); 
        $acuerdos = $academia->acuerdos($pendientes);
        return AcuerdoResource::collection($acuerdos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $academia_id, int $acuerdo_id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
