<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Academia extends Model
{
    protected $fillable = [
        'nombre', 'activa', 'departamento_id'
    ];

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    public function getPresidenteActualAttribute()
    {
        return $this->presidentes()->wherePivot('actual', '=', true)->first();
    }

    public function presidentes()
    {
        return $this->belongsToMany(User::class, 'academia_presidente',
                                    'academia_id', 'presidente_id')
                    ->withPivot('actual', 'fecha_ingreso', 'fecha_egreso');;
    }

    public function miembros()
    {
        return $this->belongsToMany(User::class, 'academia_miembro',
                                    'academia_id', 'miembro_id')
                    ->withPivot('activo', 'fecha_ingreso', 'fecha_egreso');
    }

    public function getMiembrosActualesAttribute()
    {
        return $this->miembros()->wherePivot('fecha_egreso', '=', null)->get();
    }

    public function getMiembrosActivosAttribute()
    {
        return $this->miembros()->wherePivot('activo', '=', true)->get();
    }

    public function reuniones()
    {
        return $this->hasMany(Reunion::class);
    }

    public function getAcuerdosPendientesAttribute()
    {
        $reuniones_ids = $this->reuniones->pluck('id');
        $temas_reuniones_ids = Tema::whereIn('reunion_id', $reuniones_ids)->select('id');
        return Acuerdo::where('resuelto', '=', false)->whereIn('tema_id', $temas_reuniones_ids)->get();
    }

}
