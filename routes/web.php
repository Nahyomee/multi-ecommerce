<?php

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\VendorController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\frontend\CheckoutController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\Frontend\SiteController;
use App\Http\Controllers\Frontend\UserAdressController;
use App\Http\Controllers\Frontend\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

/** Site pages */
Route::controller(SiteController::class)->group(function(){
    Route::get('/', 'index')->name('index');
    Route::get('/flash-sales', 'flashsales')->name('flash-sale');
    Route::get('/products', 'products')->name('products');
    Route::get('/products/{product}', 'product')->name('product');
    Route::get('get-product/{id}', 'getproduct')->name('get-product');
});

/** Cart */
Route::controller(CartController::class)->group(function(){
    Route::post('cart/add', 'addtocart')->name('add-to-cart');
    Route::post('cart/update', 'updatecart')->name('update-cart');
    Route::post('cart/clear', 'clearcart')->name('clear-cart');
    Route::get('cart/delete/{id}', 'deletefromcart')->name('delete-from-cart');
    Route::post('cart/delete-item', 'removefromcart')->name('delete-cart-item');
    Route::get('cart', 'cart')->name('cart');
    Route::get('cart/count', 'cartcount')->name('cart-count');
    Route::get('cart/subtotal', 'cartsubtotal')->name('cart-subtotal');
    Route::get('cart/products', 'getcartproducts')->name('cart-products');
    Route::post('apply-coupon', 'applycoupon')->name('apply-coupon');
    Route::get('remove-coupon', 'removecoupon')->name('remove-coupon');
    Route::get('coupon-calculation', 'couponcalculation')->name('coupon-calculation');
});

/** Authenticated User */
Route::middleware(['auth', 'verified', 'role:user'])
->prefix('user/')->name('user.')->group(function(){
    Route::controller(UserController::class)->group(function(){
        Route::get('/dashboard', 'dashboard')->name('dashboard');
        Route::get('/profile', 'profile')->name('profile');
        Route::put('/profile', 'updateprofile');
        Route::post('/profile/password/update', 'updatepassword')->name('password.update');
    });

    /** Addresses */
    Route::resource('address', UserAdressController::class)->except('show');

    
});

/**Checkout */
Route::controller(CheckoutController::class)->middleware(['auth', 'verified', 'role:user'])->group(function(){
    Route::get('checkout', 'index')->name('checkout-page');
    Route::post('checkout', 'checkout')->name('checkout');
});

/** Payment controller */
Route::controller(PaymentController::class)->middleware(['auth', 'verified', 'role:user'])->group(function(){
    Route::get('payment', 'index')->name('payment');

    /** Flutterwave methods */
    Route::post('rave/pay', [PaymentController::class, 'initialize'])->name('flutterwave-pay');
    Route::get('/rave/callback', [PaymentController::class, 'callback'])->name('flutterwave-callback');

     /** Flutterwave methods */
     Route::post('paystack/pay', [PaymentController::class, 'redirecttogateway'])->name('paystack-pay');
     Route::get('/paystack/callback', [PaymentController::class, 'handlegatewaycallback'])->name('paystack-callback');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/admin/login', [AdminController::class, 'login'])->name('admin.login');