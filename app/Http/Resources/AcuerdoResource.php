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
            "tema" => $this->tema,
            "fecha_de_creacion" => $this->created_at,
            "ultima_revision" => $this->fechaDeUltimaRevision,
            "fecha_finalizado" => $this->when($this->fecha_finalizado != null, $this->fecha_finalizado),
        ];;
    }
}
