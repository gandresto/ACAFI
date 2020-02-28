<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReunionResource;
use App\Notifications\AvisoInvitacionReunion;
use App\Reunion;
use App\Tema;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

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
        $data = json_decode($request->data, true);
        $data = $this->obtenerDatosValidadosReunion($data);
        // return response($data, 500);
        $reunion = DB::transaction(function () use ($data) {
            // ------ Guardo los datos de la reunión ------
            $data_reunion = Arr::only($data, ['academia_id', 'lugar', 'inicio', 'fin']);
            $reunion = Reunion::create($data_reunion);
            
            // -------- Guardar convocados ----------
            $ids_convocados = Arr::pluck($data['convocados'], 'id');
            // return response($ids_convocados, 500);
            $reunion->convocados()->sync($ids_convocados);

            // ------ Guardar invitados --------
            $ids_invitados = Arr::pluck($data['invitados'], 'id');
            $reunion->invitadosExternos()->sync($ids_invitados);

            // ------- Guardar temas --------
            $descripciones = collect(Arr::pluck($data['temas'], 'descripcion'));
            $descripciones->each(function ($descripcion) use ($reunion){
                Tema::create([
                    'descripcion' => $descripcion,
                    'reunion_id' => $reunion->id,
                ]);
            });

            // ------- Guardar acuerdos a seguimiento --------
            $ids_acuerdos = Arr::pluck($data['acuerdosASeguimiento'], 'id');
            $reunion->acuerdosASeguimiento()->sync($ids_acuerdos);

            // ------ Guardar el PDF ----------
            $reunion->crearPDFOrdenDelDia();

            return $reunion;
        });
        if($reunion->exists()){
            // ------ Enviar notificaciones ----------
            Notification::send($reunion->convocados, new AvisoInvitacionReunion($reunion));
            Notification::send($reunion->invitadosExternos, new AvisoInvitacionReunion($reunion));
            return response($reunion, 200);
        } else return response(['message' => 'Error al crear la reunión'], 500);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $reunion = Reunion::findOrFail($id);
        $this->authorize('view', $reunion);
        return (new ReunionResource($reunion));
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

    public function actualizarPDFOrdenDelDia(int $reunion_id)
    {
        // ------ Generar un nuevo documento pdf con datos existentes de la base de datos ----------
        $reunion = Reunion::findOrFail($reunion_id);
        $this->authorize('update', $reunion);

        $archivos_actualizados = $reunion->crearPDFOrdenDelDia();
        if($archivos_actualizados){
            return response([
                'message' => 'El archivo se actualizó exitosamente',
                'data' => $archivos_actualizados,
            ]);
        } else return response(['message' => 'Error al crear la reunión'], 500);
        
    }

    public function crearPDFOrdenDelDia(Request $request)
    {
        $this->authorize('create', Reunion::class);
        // return response($request->all(), 500);
        $data = json_decode($request->data, true);
        $data = $this->obtenerDatosValidadosReunion($data);
        // return response($data, 500);
        $pdf = PDF::loadView('reuniones.ordendeldia-vistaprevia', $data);
        return $pdf->download('orden_del_dia.pdf');
    }

    public function obtenerDatosValidadosReunion(Array $datos)
    {
        $datos['inicio'] = Carbon::parse($datos['inicio']);
        $datos['fin'] = Carbon::parse($datos['fin']);
        Validator::make($datos, [
            'academia_id' => 'required',
            'inicio' => 'required|after:'. Carbon::now()->subMinutes(30),
            'fin' => 'required|after:inicio',
            'lugar' => 'required',
            'convocados' => 'required',
            'convocados.*.id' => 'exists:users',
            'invitados.*.id' => 'exists:users',
            'temas' => 'required',
            'temas.*.descripcion' => 'min:3|max:191',
        ])->validate();
        return $datos;
    }
}
