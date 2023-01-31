<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\ApiUserController;
use App\Http\Controllers\Api\ApiGoogleLoginController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });




// Google login
Route::get('google/redirect', [ApiGoogleLoginController::class, 'redirect']);
Route::get('google/callback',  [ApiGoogleLoginController::class, 'callback']);

// Form login
Route::post('/login', [ApiUserController::class, 'login']);

Route::middleware('api')->group(function() {
    Route::get('/users', [UserController::class, 'index']);
    Route::post('/fill-infomation', [ApiGoogleLoginController::class, 'fillInfomation']);
});
