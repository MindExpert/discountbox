<?php

namespace App\Policies;

use App\Enums\ProductDiscountRequestStatusEnum;
use App\Models\ProductDiscountRequest;
use App\Models\User;

class ProductDiscountRequestPolicy
{
    public function viewAny(User $auth): bool
    {
        return $auth->isAdministrator();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $auth, ProductDiscountRequest $productDiscountRequest): bool
    {
        return ($auth->isAdministrator() || $auth->is($productDiscountRequest->user));
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
    public function update(User $auth, ProductDiscountRequest $productDiscountRequest): bool
    {
        return false;
        //return ($auth->isAdministrator() || $auth->is($transaction->user));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $auth, ProductDiscountRequest $productDiscountRequest): bool
    {
        return $auth->isAdministrator()
            && in_array($productDiscountRequest->status, [ProductDiscountRequestStatusEnum::REJECTED, ProductDiscountRequestStatusEnum::PENDING]);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $auth, ProductDiscountRequest $productDiscountRequest): bool
    {
        return $auth->isAdministrator();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $auth, ProductDiscountRequest $productDiscountRequest): bool
    {
        return $auth->isAdministrator()
            && in_array($productDiscountRequest->status, [ProductDiscountRequestStatusEnum::REJECTED, ProductDiscountRequestStatusEnum::PENDING]);
    }
}
