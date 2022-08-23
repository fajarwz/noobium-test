<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Me\ArticleController as MeArticleController;
use App\Http\Controllers\Me\CategoryController as MeCategoryController;
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

Route::get('/google/sign-in', [GoogleAuthController::class, 'redirectToGoogle']);
Route::get('/google/sign-in-callback', [GoogleAuthController::class, 'signInCallback']);

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{categorySlug}', [CategoryController::class, 'show']);

Route::get('/articles', [ArticleController::class, 'index']);
Route::get('/articles/{slug}', [ArticleController::class, 'show']);

Route::middleware('auth:api')->group(function ()
{
    Route::prefix('/me')->group(function ()
    {
        Route::get('/profile', [ProfileController::class, 'show']);
        Route::put('/profile', [ProfileController::class, 'update']);

        Route::get('/categories', [MeCategoryController::class, 'index']);

        Route::apiResource('articles', MeArticleController::class);
    });

    Route::post('/sign-out', [AuthController::class, 'signOut']);
});
