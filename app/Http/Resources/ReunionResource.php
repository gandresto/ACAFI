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
                'nombre' => $this->academia->nombre,
                'presidente' => new UserResource($this->academia->presidente),
            ],
            'lugar' => $this->lugar,
            'inicio' => $this->inicio,
            'fin' => $this->fin,
            'orden_del_dia' => $this->orden_del_dia,
            'minuta' => $this->minuta,
            'invitadosExternos' => $this->invitadosExternos ? UserResource::collection($this->invitadosExternos) : [],
            'convocados' => $this->convocados ? UserResource::collection($this->convocados) : [],
            'temas' => $this->temas ? TemaResource::collection($this->temas) : [],
        ];
    }
}
