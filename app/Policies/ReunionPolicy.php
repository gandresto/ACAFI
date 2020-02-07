<?php

namespace App\Policies;

use App\User;
use App\Reunion;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReunionPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        if($user->esAdmin) return true;
    }

    /**
     * Determine whether the user can view any reunions.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {

    }

    /**
     * Determine whether the user can view the reunion.
     *
     * @param  \App\User  $user
     * @param  \App\Reunion  $reunion
     * @return mixed
     */
    public function view(User $user, Reunion $reunion)
    {
        // Presidente de academia, jefe de departamento, jefe de division e invitados pueden ver reunión
        return $reunion->academia->presidente->id == $user->id 
                || $reunion->academia->departamento->jefe->id == $user->id
                || $reunion->academia->departamento->division->jefe->id == $user->id
                || $reunion->invitadosExternos->contains($user)
                || $reunion->convocados->contains($user);
    }

    /**
     * Determine whether the user can create reunions.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        // Si el usuario preside una academia, puede crear reuniones
        return $user->academiasQuePreside->isNotEmpty();
    }

    /**
     * Determine whether the user can update the reunion.
     *
     * @param  \App\User  $user
     * @param  \App\Reunion  $reunion
     * @return mixed
     */
    public function update(User $user, Reunion $reunion)
    {
        // Solo el presidente actual de la academia puede editar reuniones
        return $reunion->academia->presidente->id == $user->id;
    }

    /**
     * Determine whether the user can delete the reunion.
     *
     * @param  \App\User  $user
     * @param  \App\Reunion  $reunion
     * @return mixed
     */
    public function delete(User $user, Reunion $reunion)
    {
        // Solo el presidente actual de la academia puede eliminar reuniones
        return $reunion->academia->presidente->id == $user->id;
    }

    /**
     * Determine whether the user can restore the reunion.
     *
     * @param  \App\User  $user
     * @param  \App\Reunion  $reunion
     * @return mixed
     */
    public function restore(User $user, Reunion $reunion)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the reunion.
     *
     * @param  \App\User  $user
     * @param  \App\Reunion  $reunion
     * @return mixed
     */
    public function forceDelete(User $user, Reunion $reunion)
    {
        //
    }
    
    /**
     * Determina si el usuario puede o no crear minuta de la reunión.
     *
     * @param  \App\User  $user
     * @param  \App\Reunion  $reunion
     * @return mixed
     */
    public function crearMinuta(User $user, Reunion $reunion)
    {
        return $reunion->academia->presidente->id == $user->id &&
                $reunion->minutaPendiente();
    }
}
