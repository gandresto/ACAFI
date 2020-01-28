<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReunionResource extends JsonResource
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
            'academia' => [
                'id' => $this->academia->id,
                'nombre' => $this->academia->nombre
            ],
            'lugar' => $this->lugar,
            'inicio' => $this->inicio,
            'fin' => $this->fin,
            'orden_del_dia' => $this->orden_del_dia,
            'minuta' => $this->minuta,
            'invitados' => $this->invitados ? User::collection($this->invitados) : [],
            'convocados' => $this->convocados ? User::collection($this->convocados) : [],
            'temas' => $this->temas ? TemaResource::collection($this->temas) : [],
        ];
    }
}
