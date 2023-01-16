<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleLoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/* Google Social Login */
Route::get('/login/google', [GoogleLoginController::class, 'redirect'])->name('login.google-redirect');
Route::get('/login/google/callback', [GoogleLoginController::class, 'callback'])->name('login.google-callback');
Route::get('/login/google/show-fill-infomation', [GoogleLoginController::class, 'showFillInfomation'])->name('login.google-show-fill-infomation');
Route::post('/login/google/fill-infomation', [GoogleLoginController::class, 'fillInfomation'])->name('login.google-fill-infomation');
