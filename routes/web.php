<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestDB;
<<<<<<< HEAD
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
=======
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

>>>>>>> 2aa744249295d9f1a45cd810fd977d35914ed717
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
Route::get('/login/admin', [LoginController::class, 'showAdminLoginForm']);
Route::post('/login/admin', [LoginController::class, 'adminLogin']);
Route::get('/register/admin', [RegisterController::class, 'showAdminRegisterForm']);
Route::post('/register/admin', [RegisterController::class, 'createAdmin']);

Route::group(['middleware' => 'auth:admin'], function () {
    Route::view('/admin', 'admin');
});
Route::get('logout', [LoginController::class, 'logout']);
Route::view("homepage", "homepage");
