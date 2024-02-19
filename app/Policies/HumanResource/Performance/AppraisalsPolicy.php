<?php

namespace App\Policies\HumanResource\Performance;

use App\Models\HumanResource\Performance\Appraisal;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AppraisalsPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view_appraisals');

    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Appraisal $appraisal): bool
    {
        return $user->hasPermission('view_appraisal');

    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('create_appraisal');

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Appraisal $appraisal): bool
    {
        return $user->hasPermission('update_appraisal');

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Appraisal $appraisal): bool
    {
        return $user->hasPermission('archive_appraisal');

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Appraisal $appraisal): bool
    {
        return $user->hasPermission('restore_appraisal');

    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Appraisal $appraisal): bool
    {
        return $user->hasPermission('force_delete_appraisal');

    }
}
