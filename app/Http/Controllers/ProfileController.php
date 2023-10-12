<?php

namespace App\Http\Controllers;

use App\Enums\DiscountRequestStatusEnum;
use App\Enums\StatusEnum;
use App\Enums\TransactionTypeEnum;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\DiscountBox;
use App\Models\User;
use App\Support\ActionJsonResponse;
use App\Support\FlashNotification;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
         $this->middleware('auth');
    }

    public function edit(Request $request)
    {
        $user = auth()->user();

        $user->load([
            'transactions',
            'pending_discount_requests' => function ($query) {
                $query->with('discount_box');
            },
            'discount_requests' => function ($query) {
                $query
                    ->with('discount_box')
                    ->where('status', DiscountRequestStatusEnum::APPROVED);
            },
        ])->loadCount(['discount_requests']);

        return view('frontend.profile', compact('user'));
    }

    public function update(ProfileUpdateRequest $request, User $user)
    {
        abort_if(! $user->is(auth()->user()), 403, 'Unauthorized');

        try {
            $user->update([
                //'first_name'      => $request->input('first_name'),
                //'last_name'       => $request->input('last_name'),
                'nickname'        => $request->input('nickname'),
                'email'           => $request->input('email'),
                //'mobile'          => $request->input('mobile'),
                //'locale'          => $request->input('locale'),
                //'birth_date'      => $request->input('birth_date'),
            ]);

            if ($request->filled('password')) {
                $user->update([
                    'password' => Hash::make($request->input('password')),
                ]);
            }

            $hasNotFilledProfiled = $user->transactions()
                ->where('type', TransactionTypeEnum::PROFILE_COMPLETE)
                ->doesntExist();

            # Add credits if user has not logged the first time and has not logged in for 24 hours
            if($user->first_name !== null
                && $user->last_name !== null
                && $user->nickname !== null
                && $user->email !== null
                && $user->mobile !== null
                && $user->birth_date !== null
                && $hasNotFilledProfiled
            ) {
                $user->transactions()->create([
                    'credit' => config('app.bonuses.profile'),
                    'type'   => TransactionTypeEnum::PROFILE_COMPLETE,
                    'name'   => json_encode([
                        'lang'   => 'transaction.names.credit',
                        'params' => ['actionable' => __('transaction.event.profile')]
                    ]),
                    'notes'  => json_encode([
                        'lang'   => 'transaction.names.profile_bonus',
                        'params' => []
                    ]),
                ]);
            }

            FlashNotification::success(__('general.success'), __('user.responses.profile_updated'));
            return ActionJsonResponse::make(true, route('frontend.profile.edit', ['user' => $user->id]))->response();
        } catch (Exception $exception) {
            report($exception);

            FlashNotification::error(__('general.error'), __('user.responses.profile_not_updated'));
            return ActionJsonResponse::make(false, route('frontend.profile.edit', ['user' => $user->id]))->response();
        }
    }
}
