<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $fillable = [
        'division_id', 'nombre', 'activo'
    ];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function getJefeActualAttribute()
    {
        return $this->jefes()->wherePivot('actual', '=', true)->first();
    }

    public function jefes()
    {
        return $this->belongsToMany(User::class, 'departamento_jefe',
                                    'departamento_id', 'jefe_id')#,
                                    #'id', 'user_id')
                    ->withPivot('actual', 'fecha_ingreso', 'fecha_egreso');;
    }

    public function academias()
    {
        return $this->hasMany(Academia::class);
    }
}
