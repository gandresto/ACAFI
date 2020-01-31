<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Division extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'siglas', 'nombre', 'url', 'logo'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    // Relación muchos a muchos con tabla de usuarios. Obtiene todos los que han sido jefes de esta división
    public function jefes()
    {
        return $this->belongsToMany(User::class, 'division_jefe',
                                    'division_id', 'jefe_id')
                    ->withPivot('fecha_ingreso', 'fecha_egreso');;
    }

    // Atributo para llamar al jefe actual
    // Puede ser llamado como Division::find(1)->jefe
    public function getJefeAttribute()
    {
        return $this->jefes()->wherePivot('fecha_egreso', '=', null)->first();
    }

    // Relación uno a muchos con departamentos. Obtiene todos los departamentos de esta división
    public function departamentos()
    {
        return $this->hasMany(Departamento::class);
    }
}
