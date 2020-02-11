<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class DetallesIngresoEgreso extends Pivot
{
    protected $dates = ['fecha_ingreso', 'fecha_egreso'];

    // public function scopeActivo($query){
    //     return $query->where('fecha_egreso', '=', null);
    // }
}
