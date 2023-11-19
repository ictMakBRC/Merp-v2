<?php

namespace App\Policies\HumanResource\Performance;

use App\Models\HumanResource\Performance\Resignation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ResignationsPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view_resignations');

    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Resignation $resignation): bool
    {
        return $user->hasPermission('view_resignations');

    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('create_resignation');

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Resignation $resignation): bool
    {
        return $user->hasPermission('update_resignation');

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Resignation $resignation): bool
    {
        return $user->hasPermission('archive_resignation');

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Resignation $resignation): bool
    {
        return $user->hasPermission('restore_resignation');

    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Resignation $resignation): bool
    {
        return $user->hasPermission('force_delete_resignation');
    }
}
