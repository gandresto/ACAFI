<?php

namespace App\Http\Controllers\Api;

use App\Academia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Reunion;
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
        $this->authorize('create', Reunion::class);
        $data = $this->obtenerDatosValidadosReunion($request);
        return $data;
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
        $this->authorize('update', Reunion::find($id));
        $data = $this->obtenerDatosValidadosReunion($request);
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
        $this->authorize('create', Reunion::class);
        $data = $this->obtenerDatosValidadosReunion($request);
        $pdf = \PDF::loadView('reuniones.ordendeldia', $data);
        return $pdf->download('orden_del_dia.pdf');
    }
    public function obtenerDatosValidadosReunion(Request $request)
    {
        $val_data = $request->validate([
            'academia_id' => 'required',
            'fechaInicio' => 'required|after:'. Carbon::now('UTC')->addMinutes(-15),
            'fechaFin' => 'required|after:fechaInicio',
            'lugar' => 'required',
            'convocados' => 'required',
            'convocados.*.id' => 'exists:users',
            'invitados.*.id' => 'exists:users',
            'temas' => 'required',
        ]);

        // return response($data_val, 500);

        return [
            'academia_id' => $val_data['academia_id'],
            'fechaInicio' => Carbon::parse($val_data['fechaInicio'])->setTimeZone(config('app.timezone')),
            'fechaFin' => Carbon::parse($val_data['fechaFin'])->setTimeZone(config('app.timezone')),
            'lugar' => $val_data['lugar'],
            'convocados' => $val_data['convocados'],
            'invitados' => $request->all()['invitados'],
            'temas' => $val_data['temas'],
            'acuerdosARevision' => $request->all()['acuerdosARevision']
        ];
    }
}
