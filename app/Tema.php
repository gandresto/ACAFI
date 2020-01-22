<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tema extends Model
{
    protected $fillable = [
        'descripcion', 'comentario', 'reunion_id'
    ];
    
    public function reunion()
    {
        return $this->belongsTo(Reunion::class);
    }

    public function acuerdos()
    {
        return $this->hasMany(Acuerdo::class);
    }
}
