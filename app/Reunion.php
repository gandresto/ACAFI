<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reunion extends Model
{
    public function academia()
    {
        return $this->belongsTo('App\Academia');
    }

    public function temas()
    {
        return $this->hasMany('App\Tema');
    }

    public function academicos()
    {
        return $this->belongsToMany('App\Academico')
                    ->withPivot('asistio');
    }

    public function acuerdos()
    {
        return $this->belongsToMany('App\Acuerdo')
                    ->withPivot('avance');
    }
}
