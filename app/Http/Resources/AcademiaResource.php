<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\UserResource;

class AcademiaResource extends JsonResource
{

    private $con_ap = false; 
    private $con_miem = false; 
    private $con_pres = false;
    
    /**
     * Crea una nueva instancia de AcademiaResource
     *
     * @param mixed $resource 
     * @param bool $con_ap Muestra informacion de acuerdos pendientes si es true
     * @param bool $con_miem Muestra información de sus miembros si es true
     * @param bool $con_pres Miestra información de su presidente si es true
     **/
    public function __construct(
        $resource, 
        bool $con_ap=false, 
        bool $con_miem=false, 
        bool $con_pres=false
    ){
        parent::__construct($resource);
        $this->con_ap= $con_ap; 
        $this->con_miem= $con_miem; 
        $this->con_pres= $con_pres;
    }

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
                'presidente' => $this->when(
                    $this->con_pres, 
                    new UserResource($this->presidente),
                ),
                'miembrosActuales' => $this->when(
                    $this->con_miem, 
                    UserResource::collection($this->miembrosActuales),
                ),
                'acuerdosPendientes' => $this->when(
                    $this->con_ap, 
                    AcuerdoPendienteResource::collection($this->acuerdosPendientes->sortBy('fecha_compromiso'))
                ),
            ];
    }
}
