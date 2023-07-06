<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Management\CouponsController;
use App\Http\Controllers\Management\DashboardController;
use App\Http\Controllers\Management\DiscountBoxesController;
use App\Http\Controllers\Management\ProductsController;
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
Route::get('/dashboard')->uses([DashboardController::class, 'index'])->name('dashboard');


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

Route::prefix('/coupons')
    ->as('coupons.')
    ->group(function () {
        Route::get('/')
            ->uses([CouponsController::class, 'index'])
            ->name('index');

        Route::get('/search')
            ->uses([CouponsController::class, 'search'])
            ->name('search')
            ->middleware(['expects_json']);

        Route::get('/create')
            ->uses([CouponsController::class, 'create'])
            ->name('create');

        Route::post('/')
            ->uses([CouponsController::class, 'store'])
            ->name('store');

        Route::get('/{coupon}')
            ->uses([CouponsController::class, 'show'])
            ->name('show');

        //Route::get('/{coupon}/edit')
        //    ->uses([CouponsController::class, 'edit'])
        //    ->name('edit');
        //Route::put('/{coupon}')
        //    ->uses([CouponsController::class, 'update'])
        //    ->name('update');

        Route::delete('/{coupon}')
            ->uses([CouponsController::class, 'destroy'])
            ->name('destroy');
    });

Route::prefix('/products')
    ->as('products.')
    ->group(function () {
        Route::get('/')
            ->uses([ProductsController::class, 'index'])
            ->name('index');

        Route::get('/search')
            ->uses([ProductsController::class, 'search'])
            ->name('search')
            ->middleware(['expects_json']);

        Route::get('/image')
            ->uses([ProductsController::class, 'image'])
            ->name('image');

        Route::get('/create')
            ->uses([ProductsController::class, 'create'])
            ->name('create');

        Route::post('/')
            ->uses([ProductsController::class, 'store'])
            ->name('store');

        Route::get('/{product}')
            ->uses([ProductsController::class, 'show'])
            ->name('show');

        Route::get('/{product}/edit')
            ->uses([ProductsController::class, 'edit'])
            ->name('edit');

        Route::put('/{product}')
            ->uses([ProductsController::class, 'update'])
            ->name('update');

        Route::delete('/{product}')
            ->uses([ProductsController::class, 'destroy'])
            ->name('destroy');
    });

Route::prefix('/discount-boxes')
    ->as('discount-boxes.')
    ->group(function () {
        Route::get('/')
            ->uses([DiscountBoxesController::class, 'index'])
            ->name('index');

        Route::get('/search')
            ->uses([DiscountBoxesController::class, 'search'])
            ->name('search')
            ->middleware(['expects_json']);

        Route::get('/create')
            ->uses([DiscountBoxesController::class, 'create'])
            ->name('create');

        Route::get('/image')
            ->uses([DiscountBoxesController::class, 'image'])
            ->name('image');

        Route::post('/')
            ->uses([DiscountBoxesController::class, 'store'])
            ->name('store');

        Route::get('/{discountBox}')
            ->uses([DiscountBoxesController::class, 'show'])
            ->name('show');

        Route::get('/{discountBox}/edit')
            ->uses([DiscountBoxesController::class, 'edit'])
            ->name('edit');

        Route::put('/{discountBox}')
            ->uses([DiscountBoxesController::class, 'update'])
            ->name('update');

        Route::delete('/{discountBox}')
            ->uses([DiscountBoxesController::class, 'destroy'])
            ->name('destroy');
    });
