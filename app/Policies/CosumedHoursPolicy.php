<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CosumedHours;
use Illuminate\Auth\Access\HandlesAuthorization;

class CosumedHoursPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_cosumed::hours');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CosumedHours $cosumedHours): bool
    {
        return $user->can('view_cosumed::hours');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_cosumed::hours');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CosumedHours $cosumedHours): bool
    {
        return $user->can('update_cosumed::hours');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CosumedHours $cosumedHours): bool
    {
        return $user->can('delete_cosumed::hours');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_cosumed::hours');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, CosumedHours $cosumedHours): bool
    {
        return $user->can('force_delete_cosumed::hours');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_cosumed::hours');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, CosumedHours $cosumedHours): bool
    {
        return $user->can('restore_cosumed::hours');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_cosumed::hours');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, CosumedHours $cosumedHours): bool
    {
        return $user->can('replicate_cosumed::hours');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_cosumed::hours');
    }
}
