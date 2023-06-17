<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Management Routes
|--------------------------------------------------------------------------
|
| Here are the routes used by administration and can be accessed only
| users with the role admin, and these routes are loaded by the
| RouteServiceProvider be assigned to the "web", "auth", "admin" middleware group.
| Make something great!
|
*/
Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
