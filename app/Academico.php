<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Academico extends Model
{
    protected $table = 'academicos';

    protected $fillable = [
        'grado_id', 'nombre', 'apellido_pat', 'apellido_mat'
    ];

    // this is a recommended way to declare event handlers
    public static function boot() {
        parent::boot();
        static::deleting(function($academico) {
            $academico->user()->delete();
        });
    }

    public function nombreCompleto()
    {
        $nombre_completo = $this->nombre . ' ' .
                            $this->apellido_pat . ' ' .
                            $this->apellido_mat ;
        return $nombre_completo;
    }

    public function nombreCompletoG()
    {
        $nombre_completo = $this->grado_id . ' ' .
                            $this->nombre . ' ' .
                            $this->apellido_pat . ' ' .
                            $this->apellido_mat ;
        return $nombre_completo;
    }

    public function user()
    {
        return $this->hasOne(User::class, 'academico_id');
    }

    public function grado()
    {
        return $this->belongsTo(Grado::class);
    }

    public function jefeDeDivisiones()
    {
        return $this->hasMany(Division::class);
    }

    public function jefeDeDepartamentos()
    {
        return $this->hasMany(Departamento::class);
    }

    public function presidenteDeAcademias()
    {
        return $this->hasMany(Academia::class);
    }

    public function academias()
    {
        return $this->belongsToMany(Academia::class)
                    ->withPivot('estado', 'fecha_ingreso', 'fecha_egreso');
    }

    public function reuniones()
    {
        return $this->belongsToMany('App\Reunion')
                    ->withPivot('asistio');
    }
}
