<?php

namespace App\Policies;

use App\Enums\DiscountRequestStatusEnum;
use App\Models\DiscountRequest;
use App\Models\User;

class DiscountRequestPolicy
{
    public function viewAny(User $auth): bool
    {
        return $auth->isAdministrator();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $auth, DiscountRequest $discountRequest): bool
    {
        return ($auth->isAdministrator() || $auth->is($discountRequest->user));
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
     * Determine whether the user can approve the model.
     */
    public function toggleStatus(User $auth, DiscountRequest $discountRequest): bool
    {
        return $auth->isAdministrator()
            && $discountRequest->status === DiscountRequestStatusEnum::PENDING;
    }


    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $auth, DiscountRequest $discountRequest): bool
    {
        return $auth->isAdministrator()
            && in_array($discountRequest->status, [DiscountRequestStatusEnum::REJECTED, DiscountRequestStatusEnum::PENDING]);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $auth, DiscountRequest $discountRequest): bool
    {
        return $auth->isAdministrator();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $auth, DiscountRequest $discountRequest): bool
    {
        return $auth->isAdministrator()
            && in_array($discountRequest->status, [DiscountRequestStatusEnum::REJECTED, DiscountRequestStatusEnum::PENDING]);
    }
}
