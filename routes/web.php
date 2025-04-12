<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestDB;
<<<<<<< HEAD
use App\Http\Controllers\LoginController;
=======
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
>>>>>>> 758a7fdeb0402afb7814a5e0d2163d0729e32bdb

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

Route::get('/navigation', function() {return view('navigation');});

Route::get('/category/{gender_category}', function ($gender_category) {
    $gender_category = strtolower($gender_category);

    if ($gender_category === 'women') {
        return view('women');
    } elseif ($gender_category === 'men') {
        return view('men');
    } elseif ($gender_category === 'kids') {
        return view('kids');
    }

    return redirect('/');
})->name('category');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/profile', function () { return view('profile'); })->name('profile');
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


Route::get('/add-address', [UserController::class, 'showAddressForm'])->name('address.form');
Route::post('/store-address', [UserController::class, 'storeAddress'])->name('address.store');
