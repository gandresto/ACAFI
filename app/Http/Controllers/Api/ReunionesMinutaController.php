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
            'asistentes_ids' => 'required',
            'asistentes_ids.*' => Rule::in($reunion->convocados->pluck('id')),
        ])->validate();

        return DB::transaction(function () use ($datos, $reunion) {
            // Limpiar lista de asistencia
            $reunion->convocados()
                    ->each(function ($asistente) use ($datos){
                        if( in_array($asistente->id, $datos['asistentes_ids']) ){
                            $asistente->asistencia->asistio = true;
                        }
                        $asistente->asistencia->asistio = false;
                        $asistente->asistencia->save();
                    });
            // $reunion->convocados()
            //         ->find($datos['asistentes_ids'])
            //         ->each(function ($asistente){
            //             $asistente->asistencia->asistio = true;
            //             $asistente->asistencia->save();
            //         });
            // foreach($datos['asistentes_ids'] as $asistente_id){
            //     $asistencia = $reunion->convocados()->find($asistente_id)->asistencia;
            //     $asistencia->asistio =  true;
            //     $asistencia->save();
            // }
            foreach ($datos['temas'] as $tema) {
                $temaModel = Tema::find($tema['id']);
                $temaModel->comentario = $tema['comentario'];
                // return $tema['acuerdos'];
                $acuerdos = array_map(function ($acuerdo){
                    $acuerdoModel = new Acuerdo(Arr::only(
                        $acuerdo, 
                        ['tema_id', 'descripcion', 'producto_esperado', 'fecha_compromiso']
                    ));
                    $acuerdoModel->responsable_id = $acuerdo['responsable']['id'];
                    return $acuerdoModel;
                }, $tema['acuerdos']);
                $temaModel->save();
                $temaModel->acuerdos()->saveMany($acuerdos);
            }
            return response(['message' => 'Minuta guardada']);
        });
        return response($datos);
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
