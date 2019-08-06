<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Academia extends Model
{
    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    public function presidente()
    {
        return $this->belongsTo(Academico::class, 'id_presidente');
    }

    public function academicos()
    {
        return $this->belongsToMany(Academico::class)
                    ->withPivot('estado', 'fecha_ingreso', 'fecha_egreso');
    }

    public function reuniones()
    {
        return $this->hasMany('App\Reunion');
    }
}
