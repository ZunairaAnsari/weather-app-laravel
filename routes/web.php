<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\WeatherController;

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



Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login',[AuthController::class,  'login']);
Route::view('/dashboard', 'dashboard')->middleware('auth');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegistrationForm']);
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::post('/search', [WeatherController::class, 'search'])->name('search');

Route::view('/currencyExchange', 'currencyExchange')->name('currency')->middleware('auth');


