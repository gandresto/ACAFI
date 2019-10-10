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

    public function getesAdminAttribute()
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
                                    'jefe_id', 'division_id')#,
                                    #exit$parentKey = 'id', $relatedKey = 'division_id')
                    ->withPivot('actual', 'fecha_ingreso', 'fecha_egreso');
    }

    public function jefeActualDeDivisiones()
    {
        return $this->jefeDeDivisiones()->wherePivot('actual', '=', true);
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
