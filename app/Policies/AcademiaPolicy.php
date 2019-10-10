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
        //
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
}
