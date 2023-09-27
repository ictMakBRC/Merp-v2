<?php

namespace App\Policies\HumanResource;

use App\Models\HumanResource\Grievance;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class GrievancesPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view_grievances');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Grievance $grievance): bool
    {
        return $user->hasPermission('view_grievances');

    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('create_grievance');

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Grievance $grievance): bool
    {
        return $user->hasPermission('update_grievance');

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Grievance $grievance): bool
    {
        return $user->hasPermission('archive_grievance');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Grievance $grievance): bool
    {
        return $user->hasPermission('restore_grievance');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Grievance $grievance): bool
    {
        return $user->hasPermission('force_delete_grievance');
    }
}
