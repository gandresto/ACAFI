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
        //
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
        //
    }

    /**
     * Determine whether the user can create reunions.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
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
        //
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
        //
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
}
