<?php

namespace App\Http\Controllers\Api;

use App\Academia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReunionResource;
use App\Reunion;
use App\Tema;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
        $reunion = false;
        DB::transaction(function () use ($data, $reunion) {
            // ------ Guardo los datos de la reunión ------
            $data_reunion = [
                'academia_id' => $data['academia_id'],
                'lugar' => $data['lugar'],
                'inicio' => $data['fechaInicio'],
                'fin' => $data['fechaFin'],
            ];
            $reunion = Reunion::create($data_reunion);

            // -------- Guardar convocados ----------
            $ids_convocados = Arr::pluck($data['convocados'], 'id');
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
            $ids_acuerdos = Arr::pluck($data['acuerdosARevision'], 'id');
            $reunion->acuerdos()->sync($ids_acuerdos);

            // ------ Guardar el PDF ----------
            $reunion->crearPDFOrdenDelDia();
        });
        return $reunion ? response($reunion, 200) : response(['message' => 'Error al crear la reunión'], 500);
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
        $data = $this->obtenerDatosValidadosReunion($request);
        $pdf = \PDF::loadView('reuniones.ordendeldia.vistaprevia', $data);
        return $pdf->download('orden_del_dia.pdf');
    }

    public function obtenerDatosValidadosReunion(Request $request)
    {
        $val_data = $request->validate([
            'academia_id' => 'required',
            'fechaInicio' => 'required|after:'. Carbon::now()->subMinutes(30),
            'fechaFin' => 'required|after:fechaInicio',
            'lugar' => 'required',
            'convocados' => 'required',
            'convocados.*.id' => 'exists:users',
            'invitados.*.id' => 'exists:users',
            'temas' => 'required',
            'temas.*.descripcion' => 'min:3|max:191',
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
