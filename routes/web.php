<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestDB;
use App\Http\Controllers\LoginController;

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