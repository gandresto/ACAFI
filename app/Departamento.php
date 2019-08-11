<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $fillable = [
        'division_id', 'nombre', 'id_jefe_dpto'
    ];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function jefe()
    {
        return $this->belongsTo(Academico::class, 'id_jefe_dpto');
    }
    
    public function academias()
    {
        return $this->hasMany(Academia::class);
    }
}
