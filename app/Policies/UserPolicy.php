<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdministrator();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $auth, User $model): bool
    {
        return ($auth->isAdministrator() || $auth->is($model));
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $auth): bool
    {
        return $auth->isAdministrator();
    }

    /**
     * Determine whether the user can create models.
     */
    public function search(User $auth): bool
    {
        return $auth->isAdministrator();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $auth, User $model): bool
    {
        return ($auth->isAdministrator() || $auth->is($model));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $auth, User $model): bool
    {
        return $auth->isAdministrator();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $auth, User $model): bool
    {
        return $auth->isAdministrator();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $auth, User $model): bool
    {
        return $auth->isAdministrator();
    }
}
