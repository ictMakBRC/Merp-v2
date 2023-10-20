<?php

namespace App\Policies\HumanResource\EmployeeData\LeaveRequest;

use App\Models\HumanResource\EmployeeData\LeaveRequest\LeaveRequest;
use App\Models\User;

class LeaveRequestsPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view_leave_requests');

    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, LeaveRequest $leaveRequest): bool
    {
        return $user->hasPermission('view_leave_requests');

    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('create_leave_request');

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, LeaveRequest $leaveRequest): bool
    {
        return $user->hasPermission('update_leave_request');

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, LeaveRequest $leaveRequest): bool
    {
        return $user->hasPermission('archive_leave_request');

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, LeaveRequest $leaveRequest): bool
    {
        return $user->hasPermission('restore_leave_request');

    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, LeaveRequest $leaveRequest): bool
    {
        return $user->hasPermission('force_delete_leave_request');

    }
}
