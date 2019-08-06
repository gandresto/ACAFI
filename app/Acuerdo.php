<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Acuerdo extends Model
{
    public function tema()
    {
        return $this->belongsTo('App\Tema');
    }

    public function reuniones()
    {
        return $this->belongsToMany('App\Reunion')
                    ->withPivot('avance');
    }
}
