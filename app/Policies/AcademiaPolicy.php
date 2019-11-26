<?php

namespace App\Policies;

use App\User;
use App\Academia;
use Illuminate\Auth\Access\HandlesAuthorization;

class AcademiaPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if($user->esAdmin) return True;
    }

    /**
     * Determine whether the user can view any academias.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the academia.
     *
     * @param  \App\User  $user
     * @param  \App\Academia  $academia
     * @return mixed
     */
    public function view(User $user, Academia $academia)
    {
        return true;
    }

    /**
     * Determine whether the user can create academias.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the academia.
     *
     * @param  \App\User  $user
     * @param  \App\Academia  $academia
     * @return mixed
     */
    public function update(User $user, Academia $academia)
    {
        //
    }

    /**
     * Determine whether the user can delete the academia.
     *
     * @param  \App\User  $user
     * @param  \App\Academia  $academia
     * @return mixed
     */
    public function delete(User $user, Academia $academia)
    {
        //
    }

    /**
     * Determine whether the user can restore the academia.
     *
     * @param  \App\User  $user
     * @param  \App\Academia  $academia
     * @return mixed
     */
    public function restore(User $user, Academia $academia)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the academia.
     *
     * @param  \App\User  $user
     * @param  \App\Academia  $academia
     * @return mixed
     */
    public function forceDelete(User $user, Academia $academia)
    {
        //
    }

    public function viewMiembros(User $user, Academia $academia)
    {
        return $user->esMiembroActual($academia) || // Miembros de la academia pueden ver miembros
                $academia->presidenteActual->id == $user->id || // Presidente de academia también
                $academia->departamento->jefeActual->id == $user->id || // Jefe de departamento también
                $academia->departamento->division->jefeActual->id == $user->id; // Jefe de división también
    }

    public function addMiembro(User $user, Academia $academia)
    {
        return $academia->presidenteActual->id == $user->id; // Solo el presidente de la academia puede agregar miembros
    }

    public function darDeBajaCualquierMiembro(User $user, Academia $academia){
        return $academia->presidenteActual->id == $user->id;
    }
}
