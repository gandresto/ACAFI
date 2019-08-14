<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tema extends Model
{
    public function reunion()
    {
        return $this->belongsTo(Reunion::class);
    }

    public function acuerdos()
    {
        return $this->hasMany(Acuerdo::class);
    }
}
