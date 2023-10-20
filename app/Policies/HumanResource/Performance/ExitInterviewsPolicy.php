<?php

namespace App\Policies\HumanResource\Performance;

use App\Models\HumanResource\Performance\ExitInterview;
use App\Models\User;

class ExitInterviewsPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view_exit_interviews');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ExitInterview $exitInterview): bool
    {
        return $user->hasPermission('view_exit_interviews');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('create_exit_interview');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ExitInterview $exitInterview): bool
    {
        return $user->hasPermission('update_exit_interview');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ExitInterview $exitInterview): bool
    {
        return $user->hasPermission('archive_exit_interview');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ExitInterview $exitInterview): bool
    {
        return $user->hasPermission('restore_exit_interview');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ExitInterview $exitInterview): bool
    {
        return $user->hasPermission('force_delete_exit_interview');
    }
}
