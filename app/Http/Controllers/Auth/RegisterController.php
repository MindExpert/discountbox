<?php

namespace App\Http\Controllers\Auth;

use App\Enums\RolesEnum;
use App\Enums\TransactionTypeEnum;
use App\Events\Auth\UserLoggedIn;
use App\Events\Auth\UserRegistered;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Support\FlashNotification;
use App\Support\RedirectsUser;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default, this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    use RedirectsUser;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nickname'   => ['required', 'string', 'max:191', 'unique:users,nickname'],
            //'first_name' => ['required', 'string', 'max:191'],
            //'last_name'  => ['required', 'string', 'max:191'],
            //'birth_date' => ['nullable', 'date'],
            //'mobile'     => ['nullable', 'string', 'max:191'],
            'email'      => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password'   => ['required', 'string', 'min:8', 'confirmed'],
            'invitation_code' => ['nullable', 'string', 'exists:users,invitation_code'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'nickname'    => $data['nickname'],
            //'first_name'  => $data['first_name'],
            //'last_name'   => $data['last_name'],
            //'birth_date'  => $data['birth_date'],
            //'mobile'      => $data['mobile'],
            'email'       => $data['email'],
            'password'    => Hash::make($data['password']),
            'role'        => RolesEnum::USER,
        ]);

        if (isset($data['invitation_code']) && $data['invitation_code'] != null) {
            $inviter = User::where('invitation_code', $data['invitation_code'])->first();

            if ($inviter) {
                $user->inviter_id = $inviter->id;
                $user->save();

                $inviter->transactions()->create([
                    'credit' => config('app.bonuses.invite'),
                    'type'   => TransactionTypeEnum::INVITE,
                    'name'   => json_encode([
                        'lang'   => 'transaction.names.credit',
                        'params' => ['actionable' => __('transaction.event.invite')]
                    ]),
                    'notes'  => json_encode([
                        'lang'   => 'transaction.names.login_bonus',
                        'params' => []
                    ]),
                ]);
                // $inviter->notify(new UserInvited($user));
            }

            $user->transactions()->create([
                'credit' => config('app.bonuses.invite'),
                'type'   => TransactionTypeEnum::INVITE,
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

        return $user;
    }

    protected function registered(Request $request, $user)
    {
        $hour = Carbon::now()->format('H');

        if ($hour < 12) {
            FlashNotification::info(__('auth.welcome'), __('auth.good_morning', ['name' => auth()->user()->nickname]));
        } elseif ($hour < 18) {
            FlashNotification::info(__('auth.welcome'), __('auth.good_afternoon', ['name' => auth()->user()->nickname]));
        } else {
            FlashNotification::info(__('auth.welcome'), __('auth.good_evening', ['name' => auth()->user()->nickname]));
        }

        event(new UserRegistered($user));

        // Log the user in after registration
        auth()->login($user);

        event(new UserLoggedIn($user));

        return redirect()->to($this->redirectTo());
    }
}
