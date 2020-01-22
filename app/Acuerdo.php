<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Acuerdo extends Model
{
    protected $fillable = [
        'descripcion', 'resuelto', 'resultado', 'producto_esperado', 
        'fecha_compromiso', 'fecha_resuelto', 'tema_id',
    ];
    
    public function tema()
    {
        return $this->belongsTo(Tema::class);
    }

    public function reuniones()
    {
        return $this->belongsToMany(Reunion::class)
                    ->as('seguimiento')
                    ->withPivot('avance');
    }

    public function getFechaDeUltimaRevisionAttribute()
    {
        return $this->reuniones()->latest()->first() ?
                $this->reuniones()->latest()->first()->inicio :
                null;
    }

    public function getAcademiaAttribute()
    {
        return $this->tema->reunion->academia;
    }
}
