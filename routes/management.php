<?php

use App\Http\Controllers\Management\UsersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Management Routes
|--------------------------------------------------------------------------
|
| Here are the routes used by administration and can be accessed only
| users with the role management, and these routes are loaded by the
| RouteServiceProvider be assigned to the "web", "auth", "management" middleware group.
| Make something great!
|
*/
Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');


Route::prefix('/users')
    ->as('users.')
    ->group(function () {
        Route::get('/')
            ->uses([UsersController::class, 'index'])
            ->name('index');

        Route::get('/search')
            ->uses([UsersController::class, 'search'])
            ->name('search')
            ->middleware(['expects_json']);

        Route::get('/create')
            ->uses([UsersController::class, 'create'])
            ->name('create');

        Route::post('/')
            ->uses([UsersController::class, 'store'])
            ->name('store');

        Route::get('/{user}')
            ->uses([UsersController::class, 'show'])
            ->name('show');

        Route::get('/{user}/edit')
            ->uses([UsersController::class, 'edit'])
            ->name('edit');

        Route::put('/{user}')
            ->uses([UsersController::class, 'update'])
            ->name('update');

        Route::delete('/{user}')
            ->uses([UsersController::class, 'destroy'])
            ->name('destroy');
    });
