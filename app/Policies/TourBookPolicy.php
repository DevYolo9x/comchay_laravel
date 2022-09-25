<?php

namespace App\Policies;

use App\Models\TourBook;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TourBookPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TourBook  $tourBook
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function index(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.tour_books.index'));
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TourBook  $tourBook
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, TourBook $tourBook)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TourBook  $tourBook
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, TourBook $tourBook)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TourBook  $tourBook
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, TourBook $tourBook)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\TourBook  $tourBook
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, TourBook $tourBook)
    {
        //
    }
}
