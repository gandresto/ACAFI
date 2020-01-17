<?php

namespace App\Http\Controllers\Api;

use App\Academia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;

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
        $data_val = $request->validate([
            'fechaInicio' => 'required|before:'. Carbon::now('UTC')->addMinutes(-15),
            // 'duracion' => 'required',
            'lugar' => 'required',
            'convocados' => 'required',
            'convocados.*.id' => 'exists:users',
            'invitados.*.id' => 'exists:users',
            'temas' => 'required',
        ]);
        // return response($data_val, 500);
        $data = [
            'fechaInicio' => Carbon::parse($data_val['fechaInicio'])->setTimeZone(config('app.timezone')),
            'lugar' => $data_val['lugar'],
            'convocados' => $data_val['convocados'],
            'invitados' => $request->all()['invitados'],
            'temas' => $data_val['temas'],
            ];

        $pdf = \PDF::loadView('reuniones.ordendeldia', $data);
        // $pdf = \PDF::loadView('reuniones.ordendeldia', array($request->all()), $encoding = 'utf-8');
        return $pdf->download('orden_del_dia.pdf');
    }
}
