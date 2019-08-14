<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $fillable = [
        'siglas', 'nombre', 'jefe_div_id'
    ];

    public function jefe()
    {
        return $this->belongsTo(User::class, 'jefe_div_id');
    }

    public function departamentos()
    {
        return $this->hasMany(Departamento::class);
    }
}
