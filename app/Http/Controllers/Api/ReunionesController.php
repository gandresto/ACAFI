<?php

namespace App\Http\Controllers\Api;

use App\Academia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class ReunionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function show($id)
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

    public function crearPDFOrdenDelDia(Request $request)
    {
        // $data = collect($request->all());
        // $data = json_decode($request->all());
        // return response(($request->all()), 500);
        // return json_encode($request->all());
        // $convocados = Academia::find(1)->miembrosActuales;
        $data = [
            'fechaInicio' => $request->all()['fechaInicio'],
            'lugar' => $request->all()['lugar'],
            'convocados' => $request->all()['convocados'],
            'keys' => array_keys($request->all()['convocados']),
            // 'convocados' => $convocados,
            'invitados' => $request->all()['invitados'],
            'temas' => $request->all()['temas'],
            ];

        $pdf = \PDF::loadView('reuniones.ordendeldia', $data);
        // $pdf = \PDF::loadView('reuniones.ordendeldia', array($request->all()), $encoding = 'utf-8');
        return $pdf->download('orden_del_dia.pdf');
    }
}
