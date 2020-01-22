<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reunion extends Model
{
    protected $fillable = [
        'academia_id', 'lugar', 'inicio', 'fin', 'orden_del_dia', 'minuta'
    ];

    public function academia()
    {
        return $this->belongsTo(Academia::class);
    }

    public function temas()
    {
        return $this->hasMany(Tema::class);
    }

    public function convocados()
    {
        return $this->belongsToMany(User::class, 
        'convocado_reunion', 'reunion_id', 'convocado_id')
        ->as('asistencia')
        ->withPivot('asistio');
    }
    
    public function invitadosExternos()
    {
        return $this->belongsToMany(User::class, 
        'invitado_reunion', 'reunion_id', 'invitado_id')
        ->as('asistencia')
        ->withPivot('asistio');
    }
    
    public function acuerdos()
    {
        return $this->belongsToMany(Acuerdo::class)
        ->as('seguimiento')
        ->withPivot('avance');
    }
}
