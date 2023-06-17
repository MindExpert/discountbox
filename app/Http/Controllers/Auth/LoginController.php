<?php

namespace App\Http\Controllers\Auth;

use App\Enums\RolesEnum;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Support\FlashNotification;
use App\Support\RedirectsUser;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    //use RedirectsUser;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected string $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        $hour = Carbon::now()->format('H');

        if ($hour < 12) {
            FlashNotification::info(__('auth.welcome'), __('auth.good_morning', ['name' => auth()->user()->name]));
        } elseif ($hour < 18) {
            FlashNotification::info(__('auth.welcome'), __('auth.good_afternoon', ['name' => auth()->user()->name]));
        } else {
            FlashNotification::info(__('auth.welcome'), __('auth.good_evening', ['name' => auth()->user()->name]));
        }

        if (auth()->user()->role === RolesEnum::ADMIN) {
            return redirect()->route('management.dashboard');
        }

        return redirect()->route('homepage');
    }
}
