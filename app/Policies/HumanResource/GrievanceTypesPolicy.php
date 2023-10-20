<?php

namespace App\Policies\HumanResource;

use App\Models\HumanResource\GrievanceType;
use App\Models\User;

class GrievanceTypesPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view_grievance_types');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, GrievanceType $grievanceType): bool
    {
        return $user->hasPermission('view_grievance_types');

    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('create_grievance_type');

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, GrievanceType $grievanceType): bool
    {
        return $user->hasPermission('update_grievance_type');

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, GrievanceType $grievanceType): bool
    {
        return $user->hasPermission('archive_grievance_type');

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, GrievanceType $grievanceType): bool
    {
        return $user->hasPermission('view_grievancetypes');

    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, GrievanceType $grievanceType): bool
    {
        return $user->hasPermission('force_delete_grievance_type');

    }
}
