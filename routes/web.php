<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestDB;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', [TestDB::class, 'testDB']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/profile', [UserController::class, 'profile'])->name('profile')->middleware('auth');

Route::get('/cart', function () {
    return view('cart');
})->name('cart');

Route::get('/status', function () {
    return view('status');
})->name('status');

Route::get('/history', function () {
    return view('history');
})->name('history');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

