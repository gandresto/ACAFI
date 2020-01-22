<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $fillable = [
        'siglas', 'nombre', 'url', 'logo'
    ];

    public function getJefeAttribute()
    {
        return $this->jefes()->wherePivot('actual', '=', true)->first();
    }

    public function jefes()
    {
        return $this->belongsToMany(User::class, 'division_jefe',
                                    'division_id', 'jefe_id')
                    ->withPivot('actual', 'fecha_ingreso', 'fecha_egreso');;
    }

    public function departamentos()
    {
        return $this->hasMany(Departamento::class);
    }
}
