<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TestDB;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactUsController;

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

// Auth routes
Auth::routes();

// Home routes
Route::get('/', function () {
    return redirect('/homepage');
});
Route::get('/home', function () {
    return redirect('/homepage');
})->name('home');

// Product routes

Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/homepage', function () {
    return view('homepage');
})->name('homepage');

// Cart routes - KEEP ONLY THESE CART ROUTES
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add')->middleware('auth');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::middleware(['auth'])->group(function () {
    // Show payment page
    Route::get('/payment', [OrdersController::class, 'payment'])->name('payment');

    // Store a new order
    Route::post('/orders', [OrdersController::class, 'store'])->name('orders.store');
});
Route::get('/payment', [CartController::class, 'payment'])->name('payment');
Route::post('/orders', [CartController::class, 'storeOrder'])->name('orders.store');
Route::get('/order/confirmation/{id}', [CartController::class, 'orderConfirmation'])->name('order.confirmation');
// Product routes
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('products.show');


Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/category/{gender_category}', [CategoryController::class, 'showGenderCategories'])->name('category');


Route::get('logout', [LoginController::class, 'logout']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout.post');

// Route::get('/profile', function () {
//     return view('profile');
// })->name('profile');
Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/login/admin', [LoginController::class, 'showAdminLoginForm']);
Route::post('/login/admin', [LoginController::class, 'adminLogin']);
Route::get('/register/admin', [RegisterController::class, 'showAdminRegisterForm']);
Route::post('/register/admin', [RegisterController::class, 'createAdmin']);
Route::middleware(['auth'])->group(function () {
    // Show payment page
    Route::get('/payment', [OrdersController::class, 'payment'])->name('payment');

    // Store a new order
    Route::post('/orders', [OrdersController::class, 'store'])->name('orders.store');

    // Show order confirmation
    Route::get('/orders/confirmation/{id}', [OrdersController::class, 'confirmation'])->name('orders.confirmation');
});

Route::group(['middleware' => 'auth:admin'], function () {
    Route::view('/admin', 'admin');
});


Route::get('/profile', [UserController::class, 'profile'])->name('profile');


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

// Route::get('admin/manageproducts', [ProductController::class, 'index'])->name('admin.manageproducts')->middleware('auth.admin');
Route::middleware(['auth.admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/manageproducts', [ProductController::class, 'indexAdmin'])->name('manageproducts');
    Route::get('/products/create', [ProductController::class, 'create'])->name('createproduct');
    Route::get('/products', [ProductController::class, 'store'])->name('storeproduct');
    Route::post('/products', [ProductController::class, 'store'])->name('storeproduct');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('editproduct');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('updateproduct');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('deleteproduct');

    //test
    Route::get('updateinventory', [ProductController::class, 'updateInventory'])->name('updateinventory');
    Route::post('updateinventory', [ProductController::class, 'updateInventory'])->name('updateinventory');
    Route::get('updateinventory/{id}', [ProductController::class, 'updateInventory'])->name('updateinventory.id');
    Route::get('productinventory/{id}', [ProductController::class, 'getProductInventory'])->name('productinventory');

    // List all orders with filters
    Route::get('/orders', [OrdersController::class, 'index'])->name('manageorders');

    // Get specific order details (for AJAX)
    Route::get('/order-details/{id}', [OrdersController::class, 'getOrderDetails']);

    // Update order status
    Route::get('/update-order-status', [OrdersController::class, 'updateStatus'])->name('updateOrderStatus');
    Route::post('/update-order-status', [OrdersController::class, 'updateStatus'])->name('updateOrderStatus');
    Route::get('address/{id}', [UserController::class, 'getAddress'])->name('address.get');
    Route::get('/contactus', [ContactUsController::class, 'view'])->name('manageContactUs');

    // update the contact us information
    Route::put('/contactus', [ContactUsController::class, 'update'])->name('manageContactUs');
});


Route::get('/status', [OrdersController::class, 'showStatus'])->name('status');
Route::get('/history', [OrdersController::class, 'history'])->name('history');



