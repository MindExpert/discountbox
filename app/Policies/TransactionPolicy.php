<?php

namespace App\Policies;

use App\Models\Transaction;
use App\Models\User;

class TransactionPolicy
{
    public function viewAny(User $auth): bool
    {
        return $auth->isAdministrator();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $auth, Transaction $transaction): bool
    {
        return ($auth->isAdministrator() || $auth->is($transaction->user));
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
    public function update(User $auth, Transaction $transaction): bool
    {
        return false;
        //return ($auth->isAdministrator() || $auth->is($transaction->user));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $auth, Transaction $transaction): bool
    {
        return false;
        //return $auth->isAdministrator();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $auth, Transaction $transaction): bool
    {
        return $auth->isAdministrator();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $auth, Transaction $transaction): bool
    {
        return $auth->isAdministrator();
    }
}
