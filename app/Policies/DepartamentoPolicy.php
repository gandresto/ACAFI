<?php

namespace App\Policies;

use App\User;
use App\Departamento;
use Illuminate\Auth\Access\HandlesAuthorization;

class DepartamentoPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if($user->email == config('admin.email')) return True;
        //else return False;
    }
    
    /**
     * Determine whether the user can view any departamentos.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the departamento.
     *
     * @param  \App\User  $user
     * @param  \App\Departamento  $departamento
     * @return mixed
     */
    public function view(User $user, Departamento $departamento)
    {
        //
    }

    /**
     * Determine whether the user can create departamentos.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->email == config('admin.email');
    }

    /**
     * Determine whether the user can update the departamento.
     *
     * @param  \App\User  $user
     * @param  \App\Departamento  $departamento
     * @return mixed
     */
    public function update(User $user, Departamento $departamento)
    {
        $user_id = $user->academico->id;
        return ($user_id == $departamento->id_jefe_dpto
                || $user_id == $departamento->division->id_jefe_div
                || $user_id == $departamento->id_jefe_dpto);
    }

    /**
     * Determine whether the user can delete the departamento.
     *
     * @param  \App\User  $user
     * @param  \App\Departamento  $departamento
     * @return mixed
     */
    public function delete(User $user, Departamento $departamento)
    {
        return $user->academico->id == $departamento->division->id_jefe_div;   
    }

    /**
     * Determine whether the user can restore the departamento.
     *
     * @param  \App\User  $user
     * @param  \App\Departamento  $departamento
     * @return mixed
     */
    public function restore(User $user, Departamento $departamento)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the departamento.
     *
     * @param  \App\User  $user
     * @param  \App\Departamento  $departamento
     * @return mixed
     */
    public function forceDelete(User $user, Departamento $departamento)
    {
        //
    }
}
