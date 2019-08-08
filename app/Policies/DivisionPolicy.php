<?php

namespace App\Policies;

use App\User;
use App\Division;
use Illuminate\Auth\Access\HandlesAuthorization;

class DivisionPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any divisions.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the division.
     *
     * @param  \App\User  $user
     * @param  \App\Division  $division
     * @return mixed
     */
    public function view(User $user, Division $division)
    {
        //
    }

    /**
     * Determine whether the user can create divisions.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the division.
     *
     * @param  \App\User  $user
     * @param  \App\Division  $division
     * @return mixed
     */
    public function update(User $user, Division $division)
    {
        //
    }

    /**
     * Determine whether the user can delete the division.
     *
     * @param  \App\User  $user
     * @param  \App\Division  $division
     * @return mixed
     */
    public function delete(User $user, Division $division)
    {
        //
    }

    /**
     * Determine whether the user can restore the division.
     *
     * @param  \App\User  $user
     * @param  \App\Division  $division
     * @return mixed
     */
    public function restore(User $user, Division $division)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the division.
     *
     * @param  \App\User  $user
     * @param  \App\Division  $division
     * @return mixed
     */
    public function forceDelete(User $user, Division $division)
    {
        //
    }
}
