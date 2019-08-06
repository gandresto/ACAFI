<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function jefe()
    {
        return $this->belongsTo(Academico::class);
    }
    
    public function academias()
    {
        return $this->hasMany(Academia::class);
    }
}
