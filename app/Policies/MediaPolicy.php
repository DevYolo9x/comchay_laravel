<?php

namespace App\Policies;

use App\Models\Media;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MediaPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
    }


    public function index(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.media.index'));
    }


    public function create(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.media.create'));
    }


    public function edit(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.media.edit'));
    }


    public function destroy(User $user)
    {
        return $user->checkPermissionAccess(config('permissions.media.destroy'));
    }
}
