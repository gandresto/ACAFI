<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Acuerdo extends Model
{
    public function tema()
    {
        return $this->belongsTo(Tema::class);
    }

    public function reuniones()
    {
        return $this->belongsToMany(Reunion::class)
                    ->withPivot('avance');
    }
}
