<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Grado extends Model
{
    protected $primaryKey = 'id';
    public $incrementing = false;

    #public function academicos()
    #{
    #    return $this->hasMany(Academico::class);
    #}
}
