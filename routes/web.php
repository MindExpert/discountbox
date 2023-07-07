<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PrivateStorageController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Auth::routes();

/** INVOKABLE Controller*/
Route::put('/languages/update', LanguageController::class)->name('languages.update');

/** PRIVATE STORAGE ROUTES */
Route::prefix('/storage/local/{media}')->as('storage.local.')->middleware(['signed'])->group(function () {
    Route::get('/{fileName}')
        ->uses([PrivateStorageController::class, 'showOriginal'])
        ->name('show');

    Route::get('/conversions/{fileName}')
        ->uses([PrivateStorageController::class, 'showConversion'])
        ->name('conversions.show');
});

Route::get('/')->uses([HomeController::class, 'index'])->name('homepage');

Route::prefix('/')
    ->as('frontend.')
    ->group(function () {

        Route::get('how-it-works')
            ->uses([HomeController::class, 'howItWorks'])
            ->name('how-it-works');

        Route::get('testimonials')
            ->uses([HomeController::class, 'testimonials'])
            ->name('testimonials');

        Route::get('partners')
            ->uses([HomeController::class, 'partners'])
            ->name('partners');
    });
