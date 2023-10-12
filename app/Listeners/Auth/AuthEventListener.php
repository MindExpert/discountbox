<?php

namespace App\Listeners\Auth;

use App\Enums\TransactionTypeEnum;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Events\Dispatcher;
use Illuminate\Queue\InteractsWithQueue;
// events to Handle
use Illuminate\Support\Carbon;
use App\Events\Auth\{
    UserLoggedIn,
    UserLoggedOut,
    UserRegistered,
    UserProviderRegistered,
    UserResendConfirmationLink,
    UserVerified,
    UserDeactivated
};

class AuthEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle user login events.
     * Access the user using $event->user...
     */
    public function handleUserLogin($event): void
    {
        $ip_address = request()->getClientIp();
        $lastLogin  = $event->user->last_login_at;

        # Add credits if user has not logged the first time and has not logged in for 24 hours
        if($lastLogin == null || ! $lastLogin->isSameDay(Carbon::today())) {
            $event->user->transactions()->create([
                'credit' => config('app.bonuses.login'),
                'type'   => TransactionTypeEnum::LOGIN,
                'name'   => json_encode([
                    'lang'   => 'transaction.names.credit',
                    'params' => ['actionable' => __('transaction.event.login')]
                ]),
                'notes'  => json_encode([
                    'lang'   => 'transaction.names.login_bonus',
                    'params' => []
                ]),
            ]);
        }

        // Update the logging in users time & IP
        $event->user->fill([
            'last_login_at' => now()->toDateTimeString(),
            'last_login_ip' => $ip_address,
        ]);

        $event->user->save();

        logger('handleUserLogin');
    }

    /**
     * Handle user logout events.
     */
    public function handleUserLogout($event): void
    {
        logger('handleUserLogout');
    }

    /**
     * Handle user register events.
     */
    public function handleUserRegistered($event): void
    {
        logger('handleUserRegistered');
    }

    /**
     * Handle user register events.
     */
    public function handleUserProviderRegistered($event): void
    {
        logger('handleUserProviderRegistered');
    }

    /**
     * Handle user verified events.
     */
    public function handleUserVerified($event): void
    {
        logger('handleUserVerified');
    }

    /**
     * Handle user deactivated events.
     */
    public function handleUserDeactivated($event): void
    {
        logger('handleUserDeactivated');
    }

    /**
     * Handle user deactivated events.
     */
    public function handleUserResendConfirmationLink($event): void
    {
        logger('handleUserResendConfirmationLink');
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events): void
    {

        $events->listen(
            UserLoggedIn::class,
            'App\Listeners\Auth\AuthEventListener@handleUserLogin'
        );

        $events->listen(
            UserLoggedOut::class,
            'App\Listeners\Auth\AuthEventListener@handleUserLogout'
        );

        $events->listen(
            UserRegistered::class,
            'App\Listeners\Auth\AuthEventListener@handleUserRegistered'
        );

        $events->listen(
            UserProviderRegistered::class,
            'App\Listeners\Auth\AuthEventListener@handleUserProviderRegistered'
        );

        $events->listen(
            UserVerified::class,
            'App\Listeners\Auth\AuthEventListener@handleUserVerified'
        );

        $events->listen(
            UserDeactivated::class,
            'App\Listeners\Auth\AuthEventListener@handleUserDeactivated'
        );

        $events->listen(
            UserResendConfirmationLink::class,
            'App\Listeners\Auth\AuthEventListener@handleUserResendConfirmationLink'
        );
    }

}
