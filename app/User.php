<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

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
        'apellido_paterno', 'apellido_materno'
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

    /**
     * Buscar usuario
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $busqueda
     * @param int $num_resultados
     * 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBuscar($query, string $busqueda, int $limit)
    {
        // $connection = config('database.default');
        // $driver = config("database.connections.{$connection}.driver");
        // if ($driver == 'sqlite') {
        //     $query = $query->whereRaw("nombre || ' ' || apellido_paterno || ' ' || apellido_materno LIKE '%{$busqueda}%'")
        //                 ->orderBy('apellido_paterno')
        // } else {
            $query = $query->whereRaw("CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) LIKE '%{$busqueda}%'")
                        ->orderBy('apellido_paterno');
        // }
        return $limit ? $query->limit($limit) : $query;
    }

    /**
     * Genera un api_token único y guarda al usuario.
     *
     * @return bool
     */
    public function rollApiKey(){
        do{
           $this->api_token = Str::random(80);
        }while($this->where('api_token', $this->api_token)->exists());
        $this->save();
        return true;
    }

    /**
     * Retorna true si el usuario es miembro actual de la $academia dada.
     *
     * @param App\Academia $academia
     * @return bool
     */
    public function esMiembroActual(Academia $academia)
    {
        if ($academia->miembrosActuales->isEmpty()) return false;
        return $academia->miembrosActuales->contains($this); // Checa si hay registros donde el miembro siga activo
    }

    /**
     * Retorna true si el usuario es administrador del sistema.
     *
     * @return bool
     */
    public function getEsAdminAttribute()
    {
        return $this->email == config('admin.email');
    }

    /**
     * Retorna el nombre completo (iniciando por nombre) del usuario.
     *
     * @return string
     */
    public function getNombreCompletoAttribute()
    {
        return "{$this->nombre} {$this->apellido_paterno} {$this->apellido_materno}";
    }

    /**
     * Retorna el nombre completo (iniciando por nombre) con grado académico del usuario.
     *
     * @return string
     */
    public function getGradoNombreCompletoAttribute()
    {
        return "{$this->grado} {$this->nombre} {$this->apellido_paterno} {$this->apellido_materno}";
    }

    /* --------  Relaciones con tablas de jerarquía de la FI --------------- */

    public function divisionesQueHaDirigido()
    {
        return $this->belongsToMany(Division::class, 'division_jefe',
                                    'jefe_id', 'division_id')
                    ->using(DetallesIngresoEgreso::class)
                    ->withPivot('fecha_ingreso', 'fecha_egreso');
    }

    public function getDivisionesQueDirigeAttribute()
    {
        return $this->divisionesQueHaDirigido()->wherePivot('fecha_egreso', '=', null)->get();
    }

    public function departamentosQueHaDirigido()
    {
        return $this->belongsToMany(Departamento::class, 'departamento_jefe',
                                        'jefe_id', 'departamento_id')
                    ->using(DetallesIngresoEgreso::class)
                    ->withPivot('fecha_ingreso', 'fecha_egreso');
    }

    public function getDepartamentosQueDirigeAttribute()
    {
        return $this->departamentosQueHaDirigido()->wherePivot('fecha_egreso', '=', null)->get();
    }

    public function academiasQueHaPresidido()
    {
        return $this->belongsToMany(Academia::class, 'academia_presidente',
                                        'presidente_id', 'academia_id')
                    ->using(DetallesIngresoEgreso::class)
                    ->withPivot('fecha_ingreso', 'fecha_egreso');
    }

    public function getAcademiasQuePresideAttribute()
    {
        return $this->academiasQueHaPresidido()->wherePivot('fecha_egreso', '=', null)->get();
    }

    public function academias()
    {
        return $this->belongsToMany(Academia::class, 'academia_miembro',
                                    'miembro_id', 'academia_id')
                    ->using(DetallesIngresoEgreso::class) // Tabla pivote
                    ->withPivot('fecha_ingreso', 'fecha_egreso');
    }

    public function getAcademiasComoMiembroActivoAttribute()
    {
        return $this->academias()->wherePivot('fecha_egreso', '=', null)->get();
    }

    /* --------  Relaciones con tablas de reuniones, acuerdos, etc --------------- */

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

    public function acuerdos()
    {
        return $this->hasMany(Acuerdo::class, 'responsable_id', 'id');
    }
}
