<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $fillable = [
        'siglas', 'nombre', 'id_jefe_div'
    ];

    public function jefe()
    {
        return $this->belongsTo(Academico::class, 'id_jefe_div');
    }

    public function departamentos()
    {
        return $this->hasMany(Departamento::class);
    }
}
