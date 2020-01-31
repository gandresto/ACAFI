<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Departamento extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'division_id', 'nombre', 'activo'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function jefes()
    {
        return $this->belongsToMany(User::class, 'departamento_jefe',
                                    'departamento_id', 'jefe_id')
                    ->withPivot('fecha_ingreso', 'fecha_egreso');
    }

    public function getJefeAttribute()
    {
        return $this->jefes()->wherePivot('fecha_egreso', '=', null)->first();
    }

    public function academias()
    {
        return $this->hasMany(Academia::class);
    }
}
