<?php

namespace App\Policies;

use App\Models\DiscountBox;
use App\Models\User;

class DiscountBoxPolicy
{
    public function viewAny(User $auth): bool
    {
        return $auth->isAdministrator();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $auth, DiscountBox $discountBox): bool
    {
        return ($auth->isAdministrator() || $auth->is($discountBox->user));
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
    public function update(User $auth, DiscountBox $discountBox): bool
    {
        # TODO: prevent update when product is awarded.
        return ($auth->isAdministrator() || $auth->is($discountBox->user));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $auth, DiscountBox $discountBox): bool
    {
        return $auth->isAdministrator() || $auth->is($discountBox->user);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $auth, DiscountBox $discountBox): bool
    {
        return $auth->isAdministrator();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $auth, DiscountBox $discountBox): bool
    {
        return $auth->isAdministrator();
    }
}
