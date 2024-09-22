<?php

use App\Http\Controllers\Backend\Vendor\OrderController;
use App\Http\Controllers\Backend\Vendor\ProductController;
use App\Http\Controllers\Backend\Vendor\ProductImageController;
use App\Http\Controllers\Backend\Vendor\ProductVariantController;
use App\Http\Controllers\Backend\Vendor\ProductVariantItemController;
use App\Http\Controllers\Backend\Vendor\ShopProfileController;
use App\Http\Controllers\Backend\VendorController;
use Illuminate\Support\Facades\Route;

Route::controller(VendorController::class)->group(function(){
    Route::get('/dashboard', 'dashboard')->name('dashboard');
    Route::get('/profile', 'profile')->name('profile');
    Route::put('/profile', 'updateprofile');
    Route::post('/profile/password/update', 'updatepassword')->name('password.update');
    Route::get('get-subcategories', 'getsubcategories')->name('get-subcategories');
    Route::get('get-child-categories', 'getchildcategories')->name('get-child-categories');

});



/* Vendor Shop Profile */
Route::resource('shop-profile',ShopProfileController::class)->only(['index', 'store']);

/* Products */
Route::put('products/change-status', [ProductController::class, 'changestatus'])->name('products.change-status');
Route::resource('products',ProductController::class)->except(['show']);
Route::resource('products.images', ProductImageController::class)->only(['index', 'store', 'destroy']);
Route::resource('products.variants', ProductVariantController::class)->except(['show']);
Route::put('variant/change-status', [ProductVariantController::class, 'changestatus'])->name('products.variants.change-status');
Route::resource('variants.items', ProductVariantItemController::class)->except(['show']);
Route::put('item/change-status', [ProductVariantItemController::class, 'changestatus'])->name('variants.items.change-status');

/** Orders */
Route::post('orders/change-status', [OrderController::class, 'changeStatus'])->name('orders.change-status');
Route::get('status/orders/{status}', [OrderController::class , 'index'])->name('orders.status');
Route::resource('orders', OrderController::class);