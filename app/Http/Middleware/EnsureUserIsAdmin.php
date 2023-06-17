<?php

namespace App\Http\Middleware;

use App\Enums\RolesEnum;
use App\Support\FlashNotification;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() &&  Auth::user()->role == RolesEnum::ADMIN) {
            return $next($request);
        }

        FlashNotification::error(__('general.error'), __('general.not_allowed'));

        return redirect('/');


//        $user = $request->user();
//
//        if (! $user->role || $user->role !== RolesEnum::ADMIN->value) {
//            abort(403, 'Users Can not access this section. Its for Admins Only');
//        }
//
//        return $next($request);
    }
}
