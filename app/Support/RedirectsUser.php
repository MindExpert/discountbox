<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

trait RedirectsUser
{
    public function redirectTo()
    {
        # Default URL
        if (auth()->user()?->isUser()) {
            $defaultUrl = route('homepage');
        } else {
            $defaultUrl = route('management.dashboard');
        }
        $intendedUrl      = session()->pull('url.intended', $defaultUrl);
        $routeMiddlewares = Route::getRoutes()->match(Request::create($intendedUrl))->middleware();

        # If User is Admin, redirect to default URL (Dashboard)
        //if (in_array('ensure_user_is_admin', $routeMiddlewares)) {
        //    return $defaultUrl;
        //}

        # If User is not Admin, redirect to intended URL
        return $intendedUrl;
    }
}
