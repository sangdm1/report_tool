<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GoogleLoginController;
use App\Http\Controllers\Api\ReportController;
use App\Enums\UserRole;

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

// Google login
Route::group([
    'prefix' => 'google'
], function () {
    Route::get('/redirect', [GoogleLoginController::class, 'redirect']);
    Route::get('/callback', [GoogleLoginController::class, 'callback']);
});

// Auth login
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['jwt']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::group(['controller' => UserController::class, 'prefix' => 'users'], function () {
        Route::get('/', 'index');
        Route::get('/detail', 'show');
        Route::put('/', 'update');
    });

    Route::group(['controller' => ProjectController::class, 'prefix' => 'projects'], function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::middleware('role:' . UserRole::PM . ',' . UserRole::LEADER)->group(function () {
            Route::post('/', 'store');
            Route::put('/{id}', 'update');
            Route::delete('/{id}', 'destroy');
        });
    });

    Route::group(['controller' => ReportController::class, 'prefix' => 'reports'], function () {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('/{id}', 'show');
        Route::middleware('role:' . UserRole::MEMBER)->group(function () {
            Route::put('/{id}', 'update');
            Route::delete('/{id}', 'destroy');
        });
    });

});
