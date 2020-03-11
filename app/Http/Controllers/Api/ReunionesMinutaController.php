<?php

namespace App\Http\Controllers\Api;

use App\Acuerdo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Reunion;
use App\Tema;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ReunionesMinutaController extends Controller
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
    public function store(Request $request, int $reunion_id)
    {
        $reunion = Reunion::findOrFail($reunion_id);
        $this->authorize('update', $reunion);
        $datos = json_decode($request->data, true);
        
        // Creamos objetos de fecha para cada fecha_compromiso de los acuerdos
        foreach ($datos['temas'] as $keyTema => $tema) {
            foreach ($tema['acuerdos'] as $keyAcuerdo => $acuerdo) {
                $datos['temas'][$keyTema]['acuerdos'][$keyAcuerdo]['fecha_compromiso'] = 
                    Carbon::createFromFormat('d/m/Y', $acuerdo['fecha_compromiso']);
            }
        }
        foreach ($datos['acuerdos_a_seguimiento'] as $keyAcuerdo => $acuerdo){
            if ($acuerdo['fecha_finalizado']) {
                $datos['acuerdos_a_seguimiento'][$keyAcuerdo]['fecha_finalizado'] =
                    Carbon::createFromFormat('d/m/Y', $acuerdo['fecha_finalizado']);
            }
        }

        // return response($datos, 500);

        Validator::make($datos, [
            'miembros_que_asistieron_ids' => 'required',
            'miembros_que_asistieron_ids.*' => Rule::in($reunion->convocados->pluck('id')),
            'invitados_externos_que_asistieron_ids.*' => Rule::in($reunion->invitadosExternos->pluck('id')),
            'temas' => 'required',
            'temas.*.comentario' => 'required|min:3|max:500',
            'temas.*.acuerdos.*.descripcion' => 'required|min:3|max:191',
            'temas.*.acuerdos.*.responsable_id' => 'required',
            'temas.*.acuerdos.*.producto_esperado' => 'required|min:3|max:191',
            'temas.*.acuerdos.*.fecha_compromiso' => 'required|after:'.now(),
            'acuerdos_a_seguimiento.*.estado' => 'required|in:0,1',
            'acuerdos_a_seguimiento.*.avance_actual' => 'required_if:acuerdos_a_seguimiento.*.estado,0',
            'acuerdos_a_seguimiento.*.fecha_compromiso' => 'required_if:acuerdos_a_seguimiento.*.estado,1',
            'acuerdos_a_seguimiento.*.resultado' => 'required_if:acuerdos_a_seguimiento.*.estado,1',
        ])->validate();
        
        return response($datos, 418);

        return DB::transaction(function () use ($datos, $reunion) {
            // Actualizar lista de asistentes
            $reunion->convocados()
                    ->each(function ($asistente) use ($datos){
                        if( in_array($asistente->id, $datos['miembros_que_asistieron_ids']) ){
                            $asistente->asistencia->asistio = true;
                        } else
                            $asistente->asistencia->asistio = false;
                        $asistente->asistencia->save();
                    }
            );
            $reunion->invitadosExternos()
                    ->each(function ($asistente) use ($datos)
                    {
                        if( in_array($asistente->id, $datos['invitados_externos_que_asistieron_ids']) ){
                            $asistente->asistencia->asistio = true;
                        } else
                            $asistente->asistencia->asistio = false;
                        $asistente->asistencia->save();
                    }
            );
                  
            // ---- Rellenamos la información de temas con datos nuevos ----
            $reunion->temas()->delete(); 
            foreach ($datos['temas'] as $tema) {
                // Agregamos información del tema
                $temaModel = new Tema();
                $temaModel->reunion_id = $reunion->id;
                $temaModel->descripcion = $tema['descripcion'];
                $temaModel->comentario = $tema['comentario'];
                $temaModel->save();

                // Mapeamos los acuerdos a modelos tipo App\Acuerdo
                foreach($tema['acuerdos'] as $acuerdo){
                    $acuerdoModel = new Acuerdo();
                    $acuerdoModel->descripcion = $acuerdo['descripcion'];
                    $acuerdoModel->producto_esperado = $acuerdo['producto_esperado'];
                    $acuerdoModel->fecha_compromiso = $acuerdo['fecha_compromiso'];
                    $acuerdoModel->tema_id = $temaModel->id;
                    $acuerdoModel->responsable_id = $acuerdo['responsable']['id'];
                    $acuerdoModel->save();
                }
            }
            // ---- Creamos el documento pdf de la minuta ----
            $reunion->crearPDFMinuta();
            return response(['message' => 'Minuta guardada']);
        });
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
    public function destroy($reunion_id)
    {
        $reunion = Reunion::findOrFail($reunion_id);
        $this->authorize('eliminarMinuta', $reunion);
        $respuesta = $reunion->eliminarPDFMinuta();
        return response($respuesta);
    }
}
