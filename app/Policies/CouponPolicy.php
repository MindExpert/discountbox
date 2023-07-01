<?php

namespace App\Policies;

use App\Models\Coupon;
use App\Models\User;

class CouponPolicy
{
    public function viewAny(User $auth): bool
    {
        return $auth->isAdministrator();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $auth, Coupon $coupon): bool
    {
        return $auth->isAdministrator();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $auth): bool
    {
        return $auth->isAdministrator();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $auth, Coupon $coupon): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $auth, Coupon $coupon): bool
    {
        return $auth->isAdministrator() && ! $coupon->isApplied();
    }
}
