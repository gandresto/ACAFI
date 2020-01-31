<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;

class AcademiaResource extends JsonResource
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
                'nombre' => $this->nombre,
                'departamento' => $this->departamento,
                'presidente' => new UserResource($this->presidente),
                'miembrosActuales' => UserResource::collection($this->miembrosActuales),
            ];
    }
}
