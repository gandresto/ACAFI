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

    public function rollApiKey(){
        do{
           $this->api_token = str_random(80);
        }while($this->where('api_token', $this->api_token)->exists());
        $this->save();
     }

    public function esMiembroActual(Academia $academia)
    {
        if ($academia->miembrosActuales->isEmpty()) return false;
        return $academia->miembrosActuales->contains($this); // Checa si hay registros donde el miembro siga activo
    }

    public function getEsAdminAttribute()
    {
        return $this->email == config('admin.email');
    }

    public function getNombreCompletoAttribute()
    {
        return "{$this->nombre} {$this->apellido_pat} {$this->apellido_mat}";
    }

    public function getGradoNombreCompletoAttribute()
    {
        return "{$this->grado} {$this->nombre} {$this->apellido_pat} {$this->apellido_mat}";
    }

    /*  Relaciones con otras tablas */

    public function jefeDeDivisiones()
    {
        return $this->belongsToMany(Division::class, 'division_jefe',
                                    'jefe_id', 'division_id')
                    ->withPivot('actual', 'fecha_ingreso', 'fecha_egreso');
    }

    public function getJefeActualDeDivisionesAttribute()
    {
        return $this->jefeDeDivisiones()->wherePivot('actual', '=', true)->get();
    }

    public function jefeDeDepartamentos()
    {
        return $this->belongsToMany(Departamento::class, 'departamento_jefe',
                                        'jefe_id', 'departamento_id')
                    ->withPivot('actual', 'fecha_ingreso', 'fecha_egreso');
    }

    public function getJefeActualDeDepartamentosAttribute()
    {
        return $this->jefeDeDepartamentos()->wherePivot('actual', '=', true)->get();
    }

    public function getAcademiasQuePresidoAttribute()
    {
        return $this->belongsToMany(Academia::class, 'academia_presidente',
                                        'presidente_id', 'academia_id')
                    ->withPivot('actual', 'fecha_ingreso', 'fecha_egreso');
    }

    public function getAcademiasQuePresideAttribute()
    {
        return $this->academiasQuePresido->wherePivot('actual', '=', true)->get();
    }

    public function academias()
    {
        return $this->belongsToMany(Academia::class, 'academia_miembro',
                                    'miembro_id', 'academia_id')
                    ->withPivot('activo', 'fecha_ingreso', 'fecha_egreso');
    }

    public function reunionesComoConvocado()
    {
        return $this->belongsToMany(Reunion::class, 
            'convocado_reunion', 'convocado_id', 'reunion_id')
            ->as('asistencia')
            ->withPivot('asistio');
    }

    public function reunionesComoInvitadoExterno()
    {
        return $this->belongsToMany(Reunion::class, 
            'invitado_reunion', 'invitado_id', 'reunion_id')
            ->as('asistencia')
            ->withPivot('asistio');
    }

    public function getReunionesAttribute()
    {
        return $this->reunionesComoConvocado->merge($this->reunionesComoInvitadoExterno);
    }
}
