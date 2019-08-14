<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password',
        'grado', 'nombre', 
        'apellido_pat', 'apellido_mat'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

        /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function nombreCompleto()
    {
        $nombre_completo = $this->nombre . ' ' .
                            $this->apellido_pat . ' ' .
                            $this->apellido_mat ;
        return $nombre_completo;
    }

    public function nombreCompletoYGrado()
    {
        $nombre_completo = $this->grado . ' ' .
                            $this->nombre . ' ' .
                            $this->apellido_pat . ' ' .
                            $this->apellido_mat ;
        return $nombre_completo;
    }

    /*  Relaciones con otras tablas */

    public function jefeDeDivisiones()
    {
        return $this->hasMany(Division::class, 'jefe_div_id');
    }

    public function jefeDeDepartamentos()
    {
        return $this->hasMany(Departamento::class, 'jefe_dpto_id');
    }

    public function presidenteDeAcademias()
    {
        return $this->hasMany(Academia::class, 'presidente_id');
    }

    public function academias()
    {
        return $this->belongsToMany(Academia::class)
                    ->withPivot('activo', 'fecha_ingreso', 'fecha_egreso');
    }

    public function reuniones()
    {
        return $this->belongsToMany(Reunion::class)
                    ->withPivot('asistio');
    }
}
