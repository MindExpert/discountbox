<?php

namespace App\Http\Controllers\Auth;

use App\Enums\RolesEnum;
use App\Events\Auth\UserLoggedIn;
use App\Events\Auth\UserLoggedOut;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Support\FlashNotification;
use App\Support\RedirectsUser;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
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
    use RedirectsUser;

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

        event(new UserLoggedIn($user));

        return redirect()->to($this->redirectTo());
    }

    public function logout(Request $request)
    {
        // Fire event, Log out user, Redirect
        event(new UserLoggedOut($request->user()));

        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        //return $this->loggedOut($request) ?: redirect('/');

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }
}
