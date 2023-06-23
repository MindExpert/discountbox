<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * @message To be used when the user has a locale set in the database
 * Class UserLocale
 * @package App\Http\Middleware
 */
class UserLocale
{
    /**
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function handle(Request $request, Closure $next)
    {
        $locale = config('app.locale');

        if (user() && in_array(user()->locale, config('app.locales'))) {
            $locale = user()->locale;
        } elseif (session()->get('locale') && in_array(session()->get('locale'), config('app.locales'))) {
            $locale = session()->get('locale');
        }

        session()->put('locale', $locale);

        App::setLocale($locale);

        Carbon::setLocale($locale);

        return $next($request);
    }
}
