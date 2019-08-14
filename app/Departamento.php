<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    protected $fillable = [
        'division_id', 'nombre', 'jefe_dpto_id'
    ];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function jefe()
    {
        return $this->belongsTo(User::class, 'jefe_dpto_id');
    }
    
    public function academias()
    {
        return $this->hasMany(Academia::class);
    }
}
