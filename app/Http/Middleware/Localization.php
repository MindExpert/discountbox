<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

/**
 * @messageTo be used when localization is saved in the browser session
 * Class Localization
 * @package App\Http\Middleware
 */
class Localization
{
    public function handle(Request $request, Closure $next)
    {
        $locale = config('app.locale');

        if (Session::has('locale') && in_array(Session::get('locale'), config('app.locales'))) {
            $locale = Session::get('locale');
        }

        App::setLocale($locale);
        Carbon::setLocale($locale);

        session()->put('locale', $locale);

        return $next($request);
    }
}
