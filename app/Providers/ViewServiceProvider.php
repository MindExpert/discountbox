<?php

namespace App\Providers;

use App\Http\ViewComposers\UserCreditBalanceComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(UserCreditBalanceComposer::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        /**
         * @see
         *  View::share() is really straight forward it sets a variable which can be used within any of the views, think of it like a global variable.
         *  View::composer() registers an event which is called when the view is rendered
         *  View::creator() which is fired when a view is instantiated.
         *
         * @example
         * View::composer('admin.*', 'App\Http\ViewComposers\ProfileComposer');
         * View::composer('*.index', 'App\Http\ViewComposers\ProfileComposer');
         * View::composer('view', 'App\Http\ViewComposers\ProfileComposer');
         * View::composer(['profile', 'dashboard'], 'App\Http\ViewComposers\ProfileComposer');
         * View::composer(['profile.*', '*.dashboard'], 'App\Http\ViewComposers\ProfileComposer');
         */
        View::composer([
            '_partials.frontend.navigation',
            'frontend.profile',
            'frontend.discount-boxes.show',
        ], UserCreditBalanceComposer::class);
    }
}
