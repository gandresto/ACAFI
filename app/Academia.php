<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Academia extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre', 'departamento_id'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    public function getPresidenteAttribute()
    {
        return $this->presidentes()->wherePivot('fecha_egreso', '=', null)->first();
    }

    public function presidentes()
    {
        return $this->belongsToMany(User::class, 'academia_presidente',
                                    'academia_id', 'presidente_id')
                    ->withPivot('fecha_ingreso', 'fecha_egreso');;
    }

    public function miembros()
    {
        return $this->belongsToMany(User::class, 'academia_miembro',
                                    'academia_id', 'miembro_id')
                    ->withPivot('fecha_ingreso', 'fecha_egreso');
    }

    public function getMiembrosActualesAttribute()
    {
        return $this->miembros()
                    ->wherePivot('fecha_egreso', '=', null)
                    ->get()
                    ->sortBy(function ($miembro){
                        return nombre_completo($miembro, $ordenarPor = 'apellido');
                    });
    }

    public function getMiembrosActivosAttribute()
    {
        return $this->miembros()
                    ->wherePivot('fecha_egreso', '=', null)
                    ->get()
                    ->sortBy(function ($miembro){
                        return nombre_completo($miembro, $ordenarPor = 'apellido');
                    });
    }

    public function reuniones()
    {
        return $this->hasMany(Reunion::class);
    }

    public function getAcuerdosPendientesAttribute()
    {
        $reuniones_ids = $this->reuniones->pluck('id');
        $temas_reuniones_ids = Tema::whereIn('reunion_id', $reuniones_ids)->select('id');
        return Acuerdo::pendientes()->whereIn('tema_id', $temas_reuniones_ids)->get();
    }

}
