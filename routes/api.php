<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Me\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::post('/sign-up', [AuthController::class, 'signUp'])->name('sign-up');
Route::post('/sign-in', [AuthController::class, 'signIn'])->name('sign-in');
Route::middleware('auth:api')->group(function ()
{
    Route::prefix('/me')->group(function () {
        Route::get('/profile', [ProfileController::class, 'show'])->name('me.profile.show');
    });

    Route::post('/sign-out', [AuthController::class, 'signOut'])->name('auth.sign-out');
});
