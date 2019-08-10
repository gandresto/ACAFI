<?php

namespace App\Policies;

use App\User;
use App\Academico;
use Illuminate\Auth\Access\HandlesAuthorization;

class AcademicoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any academicos.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->email == config('admin.email');
    }

    /**
     * Determine whether the user can view the academico.
     *
     * @param  \App\User  $user
     * @param  \App\Academico  $academico
     * @return mixed
     */
    public function view(User $user, Academico $academico)
    {
        //
    }

    /**
     * Determine whether the user can create academicos.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the academico.
     *
     * @param  \App\User  $user
     * @param  \App\Academico  $academico
     * @return mixed
     */
    public function update(User $user, Academico $academico)
    {
        return $academico->user->email != config('admin.email') &&
                $user->email == config('admin.email');
    }

    /**
     * Determine whether the user can delete the academico.
     *
     * @param  \App\User  $user
     * @param  \App\Academico  $academico
     * @return mixed
     */
    public function delete(User $user, Academico $academico)
    {
        $academico->user->email != config('admin.email') &&
                $user->email == config('admin.email');
    }

    /**
     * Determine whether the user can restore the academico.
     *
     * @param  \App\User  $user
     * @param  \App\Academico  $academico
     * @return mixed
     */
    public function restore(User $user, Academico $academico)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the academico.
     *
     * @param  \App\User  $user
     * @param  \App\Academico  $academico
     * @return mixed
     */
    public function forceDelete(User $user, Academico $academico)
    {
        $academico->user->email != config('admin.email') &&
                $user->email == config('admin.email');
    }
}
