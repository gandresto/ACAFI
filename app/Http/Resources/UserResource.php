<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'grado' =>  $this->grado,
            'nombre' =>  $this->nombre,
            'apellido_paterno' =>  $this->apellido_pat,
            'apellido_materno' =>  $this->apellido_mat,
            'email' =>  $this->email,
            // 'api_token' => $this->when(Auth::user()->esAdmin, $this->api_token),
            'info_miembro' => $this->whenPivotLoaded('academia_miembro', function () {
                return [
                    'actual' => $this->pivot->actual,
                    'fecha_ingreso' => $this->pivot->fecha_ingreso,
                    'fecha_egreso' =>  $this->pivot->fecha_egreso,
                ];
            }),
            'info_presidente' => $this->whenPivotLoaded('academia_presidente', function () {
                return [
                    'fecha_ingreso' => $this->pivot->fecha_ingreso,
                    'fecha_egreso' =>  $this->pivot->fecha_egreso,
                ];
            }),
        ];
    }
}
