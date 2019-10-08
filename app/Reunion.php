<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reunion extends Model
{
    public function academia()
    {
        return $this->belongsTo(Academia::class);
    }

    public function temas()
    {
        return $this->hasMany(Tema::class);
    }

    public function invitados()
    {
        return $this->belongsToMany(User::class)
                    ->withPivot('asistio');
    }

    public function acuerdos()
    {
        return $this->belongsToMany(Acuerdo::class)
                    ->withPivot('avance');
    }
}
