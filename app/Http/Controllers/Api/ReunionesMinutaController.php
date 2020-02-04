<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Reunion;
use Carbon\Carbon;
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
        // $datos->temas->each(function)
        Validator::make($datos, [
            'temas' => 'required',
            'temas.*.comentario' => 'required|min:3|max:500',
            'temas.*.acuerdos.*.descripcion' => 'min:3|max:191',
            'temas.*.acuerdos.*.fecha_compromiso' => function ($campo, $valor, $fail) {
                if (Carbon::createFromFormat('d/m/Y', $valor)->isBefore(Carbon::now())) {
                    $fail($campo.' debe ser una fecha posterior a '. Carbon::now()->format('d/m/Y'));
                }
            },
            'asistentes_ids' => 'required',
            'asistentes_ids.*' => Rule::in($reunion->convocados->pluck('id')),
        ])->validate();
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
