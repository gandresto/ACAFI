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

    public function divisionesQueHaDirigido()
    {
        return $this->belongsToMany(Division::class, 'division_jefe',
                                    'jefe_id', 'division_id')
                    ->withPivot('actual', 'fecha_ingreso', 'fecha_egreso');
    }

    public function getDivisionesQueDirigeAttribute()
    {
        return $this->divisionesQueHaDirigido()->wherePivot('actual', '=', true)->get();
    }

    public function departamentosQueHaDirigido()
    {
        return $this->belongsToMany(Departamento::class, 'departamento_jefe',
                                        'jefe_id', 'departamento_id')
                    ->withPivot('actual', 'fecha_ingreso', 'fecha_egreso');
    }

    public function getDepartamentosQueDirigeAttribute()
    {
        return $this->departamentosQueHaDirigido()->wherePivot('actual', '=', true)->get();
    }

    public function academiasQueHaPresidido()
    {
        return $this->belongsToMany(Academia::class, 'academia_presidente',
                                        'presidente_id', 'academia_id')
                    ->withPivot('actual', 'fecha_ingreso', 'fecha_egreso');
    }

    public function getAcademiasQuePresideAttribute()
    {
        return $this->academiasQueHaPresidido()->wherePivot('actual', '=', true)->get();
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
    
    public function getReunionesComoPresidenteAttribute()
    {
        return Reunion::whereIn('academia_id', $this->academiasQuePreside->pluck('id'))->get();
    }
    
    public function getReunionesComoJefeDeDepartamentoAttribute()
    {
        return Reunion::whereIn('academia_id', // Consulta principal (reuniones de las academias)
                Academia::whereIn('departamento_id', // Subconsulta 1 (academias del departamento)
                                $this->departamentosQueDirige->pluck('id') 
                            )->get()->pluck('id')
                        )->get();
    }
    
    public function getReunionesComoJefeDeDivisionAttribute()
    {
        return Reunion::whereIn('academia_id', // Consulta principal (reuniones de las academias)
                Academia::whereIn('departamento_id', // Subconsulta 1 (academias de departamentos que dirige)
                    Departamento::whereIn('division_id', // Subconsulta 2 (departamentos de divisiones que dirige)
                        $this->divisionesQueDirige->pluck('id') 
                    )->get()->pluck('id')
                )->get()->pluck('id')
            )->get();
    }

    public function getReunionesAttribute()
    {
        // Union entre todas las consultas
        return $this->reunionesComoConvocado->merge(
            $this->reunionesComoInvitadoExterno->merge(
                $this->ReunionesComoPresidente->merge(
                    $this->reunionesComoJefeDeDepartamento->merge(
                        $this->reunionesComoJefeDeDivision
                    )
                )
            )
        );
    }
}
