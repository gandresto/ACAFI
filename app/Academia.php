<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Academia extends Model
{
    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    public function getPresidenteActualAttribute()
    {
        return $this->presidentes()->wherePivot('actual', '=', true)->first();
    }

    public function presidentes()
    {
        return $this->belongsToMany(User::class, 'division_presidente',
                                    'division_id', 'presidente_id')#,
                                    #'id', 'user_id')
                    ->withPivot('actual', 'fecha_ingreso', 'fecha_egreso');;
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
