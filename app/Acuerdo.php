<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Acuerdo extends Model
{
    protected $fillable = [
        'descripcion', 'resultado', 'producto_esperado', 
        'fecha_compromiso', 'fecha_finalizado', 'tema_id', 
        'responsable_id'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['fecha_compromiso', 'fecha_finalizado'];

    /**
     * Filtrar una consulta para incluir solo asuntos resueltos.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFinalizados($query)
    {
        return $query->where('fecha_finalizado', 'NOT', null);
    }

    /**
     * Filtrar una consulta para incluir solo asuntos pendientes.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePendientes($query)
    {
        return $query->where('fecha_finalizado', '=', null);
    }

    /**
     * Filtrar una consulta para incluir solo asuntos atrasados.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAtrasados($query)
    {
        return $query->whereDate('fecha_compromiso', '<', Carbon::now());
    }
    
    public function tema()
    {
        return $this->belongsTo(Tema::class);
    }

    public function reuniones()
    {
        return $this->belongsToMany(Reunion::class)
                    ->as('seguimiento')
                    ->withPivot('avance');
    }

    public function getFechaDeUltimaRevisionAttribute()
    {
        return $this->reuniones()->latest()->first() ?
                $this->reuniones()->latest()->first()->inicio :
                null;
    }

    public function getAcademiaAttribute()
    {
        return $this->tema->reunion->academia;
    }

    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }
}
