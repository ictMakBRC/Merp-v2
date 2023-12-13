<?php

namespace App\Policies\HumanResource\Performance;

use App\Models\HumanResource\Performance\Warning;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class WarningsPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view_warnings');

    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Warning $warning): bool
    {
        return $user->hasPermission('view_warning');

    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('create_warning');

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Warning $warning): bool
    {
        return $user->hasPermission('update_warning');

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Warning $warning): bool
    {
        return $user->hasPermission('archive_warning');

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Warning $warning): bool
    {
        return $user->hasPermission('restore_warning');

    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Warning $warning): bool
    {
        return $user->hasPermission('force_delete_warning');
    }
}
