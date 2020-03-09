<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AcuerdoResource extends JsonResource
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
            "id" => $this->id,
            "descripcion" => $this->descripcion,
            "producto_esperado" => $this->producto_esperado,
            "fecha_compromiso" => $this->fecha_compromiso,
            "resultado" => $this->resultado,
            "tema" => [
                "id" => $this->tema->id,
                "descripcion" => $this->tema->descripcion,
            ],
            "responsable" => [
                'id' => $this->responsable->id,
                'nombre_completo' => $this->responsable->gradoNombreCompleto,
            ],
            "fecha_de_creacion" => $this->tema->reunion->inicio,
            "ultima_revision" => $this->fechaDeUltimaRevision,
            "fecha_finalizado" => $this->fecha_finalizado,
            'avance' => $this->whenPivotLoadedAs('avance', 'acuerdo_reunion', $this->avance),
        ];
    }
}
