<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GoogleLoginController;

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

Route::group(['middleware' => ['api']], function () {

    Route::controller(UserController::class)->group(function () {
        Route::group([
            'prefix' => 'users'
        ], function () {
            Route::get('/', 'index');
            Route::get('/{id}', 'show');
            Route::put('/{id}', 'update');
        });
    });
});
