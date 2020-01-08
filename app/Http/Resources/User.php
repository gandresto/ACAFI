<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class User extends JsonResource
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
            "grado" =>  $this->grado,
            "nombre" =>  $this->nombre,
            "apellido_pat" =>  $this->apellido_pat,
            "apellido_mat" =>  $this->apellido_mat,
            "email" =>  $this->email,
            "api_token" => $this->when(Auth::user()->esAdmin, $this->api_token),

        ];
    }
}