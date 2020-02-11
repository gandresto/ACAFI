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
    
    public function getDivisionAttribute()
    {
        return $this->departamento->division;
    }

    public function presidentes()
    {
        return $this->belongsToMany(User::class, 'academia_presidente',
                                    'academia_id', 'presidente_id')
                    ->using(DetallesIngresoEgreso::class)
                    ->withPivot('fecha_ingreso', 'fecha_egreso');;
    }

    public function getPresidenteAttribute()
    {
        return $this->presidentes()->wherePivot('fecha_egreso', '=', null)->first();
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
                    ->wherePivot('activo', '=', null)
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

    /**
     * Acuerdos que tiene esta academia. Cuando el $estado_fin es 'pend', la función 
     * retornará sólo acuerdos pendientes. Cuando $estado_fin es 'fin', retornará 
     * únicamente acuerdos finalizados. En cualquier otro caso, la función retornará tanto
     * acuerdos finalizados como los pendientes.
     * 
     * @param string $estado_fin 
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function acuerdos(string $estado_fin = null)
    {
        $reuniones_ids = $this->reuniones->pluck('id');
        $temas_reuniones_ids = Tema::whereIn('reunion_id', $reuniones_ids)->select('id');
        $query = Acuerdo::whereIn('tema_id', $temas_reuniones_ids);
        if($estado_fin == 'pend') $query = $query->pendientes();
        else if($estado_fin == 'fin') $query = $query->finalizados();
        return $query->get();
    }

}
