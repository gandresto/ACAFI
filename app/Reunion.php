<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Reunion extends Model
{
    protected $fillable = [
        'academia_id', 'lugar', 'inicio', 'fin', 'orden_del_dia', 'minuta', 'cancelada'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['inicio', 'fin'];

    /**
     * Filtrar una consulta para incluir solo reuniones canceladas.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCanceladas($query)
    {
        return $query->where('cancelada', '=', false);
    }

    /**
     * Filtrar una consulta para incluir reuniones próximas.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeProximas($query)
    {
        return $query->whereDate('inicio', '>', Carbon::now());
    }

    /**
     * Filtrar una consulta para incluir reuniones pasadas.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePasadas($query)
    {
        return $query->whereDate('fin', '<', Carbon::now());
    }

    public function academia()
    {
        return $this->belongsTo(Academia::class);
    }

    public function temas()
    {
        return $this->hasMany(Tema::class);
    }

    public function convocados()
    {
        return $this->belongsToMany(User::class, 
        'convocado_reunion', 'reunion_id', 'convocado_id')
        ->as('asistencia')
        ->withPivot('asistio');
    }
    
    public function invitadosExternos()
    {
        return $this->belongsToMany(User::class, 
        'invitado_reunion', 'reunion_id', 'invitado_id')
        ->as('asistencia')
        ->withPivot('asistio');
    }
    
    public function acuerdosARevision()
    {
        return $this->belongsToMany(Acuerdo::class)
        ->as('seguimiento')
        ->withPivot('avance');
    }

    /**
     * Devuelve true si no se ha hecho la minuta y la reunión ya terminó
     * 
     * @return bool
     */
    public function minutaPendiente()
    {
        // Ya terminó la reunión y aún no se hacen minutas
        return ($this->fin < Carbon::now()) && ! $this->minuta;
    }

    public function crearPDFOrdenDelDia()
    {
        $pdf = \PDF::loadView('reuniones.ordendeldia', ['reunion' => $this]);
        // Generar nombre del archivo a guardar
        $fecha_str = $this->inicio->format('Ymd_His'); // Formato de fecha
        $id_str = sprintf("%04d", $this->id); // Relleno con 4 ceros
        $nombre_archivo = "Divisiones/{$this->academia->departamento->division->id}/";
        $nombre_archivo .= "Departamentos/{$this->academia->departamento->id}/";
        $nombre_archivo .= "Academias/{$this->academia->id}/od{$id_str}_{$fecha_str}.pdf";
        
        $archivo_antiguo = $this->orden_del_dia; // Guardo el nombre anterior
        // dd($archivo_antiguo);
        $this->orden_del_dia = $nombre_archivo; // Sustituyo el nombre
        $content = $pdf->download()->getOriginalContent(); // Obtengo el contenido del archivo en memoria
        if($archivo_antiguo && Storage::exists($archivo_antiguo)){
            Storage::delete($archivo_antiguo); // Borramos el archivo anterior
        }
        Storage::put($nombre_archivo, $content, 'private'); // Guardo el nuevo archivo
        $this->save();
        return [
            'borrado' => $archivo_antiguo,
            'creado' => $nombre_archivo,
        ];
    }
}
