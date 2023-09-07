<?php

namespace App\Policies\HumanResource\Performance;

use App\Models\HumanResource\Performance\Termination;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TerminationsPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view_terminations');

    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Termination $termination): bool
    {
        return $user->hasPermission('view_terminations');

    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('create_termination');

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Termination $termination): bool
    {
        return $user->hasPermission('update_termination');

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Termination $termination): bool
    {
        return $user->hasPermission('archive_termination');

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Termination $termination): bool
    {
        return $user->hasPermission('restore_termination');

    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Termination $termination): bool
    {
        return $user->hasPermission('force_delete_termination');

    }
}
