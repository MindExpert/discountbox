<?php

namespace App\Http\ViewComposers;

use App\Enums\AccountTypesEnum;
use App\Enums\CurrencyEnum;
use App\Models\Account;
use Illuminate\View\View;

class UserCreditBalanceComposer
{
    /**
     * User Account Transaction sum
     */
    protected static $userCreditBalance;

    /**
     * composer.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Bind data to the view.
     * @param  View  $view
     * @return void
     */
    public function compose(View $view): void
    {
        if (! static::$userCreditBalance) {
            static::$userCreditBalance = auth()->check() ? auth()->user()->availableBalance() : null;
        }

        $view->with('user_credit_balance', static::$userCreditBalance);
    }
}
