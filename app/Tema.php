<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tema extends Model
{
    public function reunion()
    {
        return $this->belongsTo('App\Reunion');
    }

    public function acuerdos()
    {
        return $this->hasMany('App\Acuerdo');
    }
}
