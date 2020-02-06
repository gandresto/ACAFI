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

        foreach ($datos['temas'] as $keyTema => $tema) {
            foreach ($tema['acuerdos'] as $keyAcuerdo => $acuerdo) {
                $datos['temas'][$keyTema]['acuerdos'][$keyAcuerdo]['fecha_compromiso'] = 
                    Carbon::createFromFormat('d/m/Y', $acuerdo['fecha_compromiso']);
            }
        }

        Validator::make($datos, [
            'temas' => 'required',
            'temas.*.comentario' => 'required|min:3|max:500',
            'temas.*.acuerdos.*.descripcion' => 'min:3|max:191',
            // 'temas.*.acuerdos.*.fecha_compromiso' => function ($campo, $valor, $fail) {
            //     if (Carbon::createFromFormat('d/m/Y', $valor)->isBefore(Carbon::now())) {
            //         $fail($campo.' debe ser una fecha posterior a '. Carbon::now()->format('d/m/Y'));
            //     }
            // },
            'temas.*.acuerdos.*.fecha_compromiso' => 'after:'.now(),
            'miembros_que_asistieron_ids' => 'required',
            'miembros_que_asistieron_ids.*' => Rule::in($reunion->convocados->pluck('id')),
            'invitados_externos_que_asistieron_ids.*' => Rule::in($reunion->invitadosExternos->pluck('id')),
        ])->validate();

        return DB::transaction(function () use ($datos, $reunion) {
            // Limpiar lista de asistencia
            $reunion->convocados()
                    ->each(function ($asistente) use ($datos){
                        if( in_array($asistente->id, $datos['miembros_que_asistieron_ids']) ){
                            $asistente->asistencia->asistio = true;
                        } else
                            $asistente->asistencia->asistio = false;
                        $asistente->asistencia->save();
                    });
            $reunion->invitadosExternos()
                    ->each(function ($asistente) use ($datos){
                        if( in_array($asistente->id, $datos['invitados_externos_que_asistieron_ids']) ){
                            $asistente->asistencia->asistio = true;
                        } else
                            $asistente->asistencia->asistio = false;
                        $asistente->asistencia->save();
                    });
            // $reunion->convocados()
            //         ->find($datos['miembrosQueAsistieron_ids'])
            //         ->each(function ($asistente){
            //             $asistente->asistencia->asistio = true;
            //             $asistente->asistencia->save();
            //         });
            // foreach($datos['miembrosQueAsistieron_ids'] as $asistente_id){
            //     $asistencia = $reunion->convocados()->find($asistente_id)->asistencia;
            //     $asistencia->asistio =  true;
            //     $asistencia->save();
            // }

            // ---- Rellenamos la información de temas con datos nuevos ----
            foreach ($datos['temas'] as $tema) {
                $temaModel = Tema::find($tema['id']);

                // Agregamos a cada tema su comentario
                $temaModel->comentario = $tema['comentario'];
                $temaModel->save();

                // Mapeamos los acuerdos a modelos tipo App\Acuerdo
                $acuerdos = array_map(function ($acuerdo){
                    // Creamos nuevos acuerdos con ciertos campos
                    $acuerdoModel = new Acuerdo(Arr::only(
                        $acuerdo, 
                        ['tema_id', 'descripcion', 'producto_esperado', 'fecha_compromiso']
                    ));
                    
                    // Agregamos el id del responsable del acuerdo
                    $acuerdoModel->responsable_id = $acuerdo['responsable']['id'];
                    return $acuerdoModel;
                }, $tema['acuerdos']);

                // Guardamos los acuerdos en la base de datos
                $temaModel->acuerdos()->saveMany($acuerdos);
            }
            // ---- Creamos el documento pdf de la minuta ----
            $reunion->crearPDFMinuta();
            return response(['message' => 'Minuta guardada']);
        });
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
}
