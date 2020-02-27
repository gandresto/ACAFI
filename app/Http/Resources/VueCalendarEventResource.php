<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VueCalendarEventResource extends JsonResource
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
            'start' => $this->inicio->format('Y-m-d H:i'),
            'end' => $this->fin->format('Y-m-d H:i'),
            'title' => "{$this->academia->nombre}",
            'content' => "Lugar: {$this->lugar}",
            'link' => route('reuniones.show', $this->id),
            // 'class' => $this->inicio,
            // 'background' => true,
        ];
    }
}
