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
        return $this->belongsTo(User::class, 'presidente_id');
    }

    public function miembros()
    {
        return $this->belongsToMany(User::class)
                    ->withPivot('activo', 'fecha_ingreso', 'fecha_egreso');
    }

    public function reuniones()
    {
        return $this->hasMany(Reunion::class);
    }
}
