<?php

use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\AdminVendorProfileController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\ChildCategoryController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\FlashSaleController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\PaymentController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ProductImageController;
use App\Http\Controllers\Backend\ProductVariantController;
use App\Http\Controllers\Backend\ProductVariantItemController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\ShippingRuleController;
use App\Http\Controllers\Backend\SliderController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\TransactionController;
use App\Http\Controllers\Backend\VendorProductController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
Route::get('get-subcategories',[AdminController::class, 'getsubcategories'])->name('get-subcategories');
Route::get('get-child-categories',[AdminController::class, 'getchildcategories'])->name('get-child-categories');

/** Profile routes */
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::post('/profile', [ProfileController::class, 'updateprofile']);
Route::post('/password/update', [ProfileController::class, 'updatepassword'])->name('password.update');

/** Slider routes */
Route::resource('sliders', SliderController::class);

/** Category routes */
Route::put('categories/change-status', [CategoryController::class, 'changestatus'])->name('categories.change-status');
Route::resource('categories',CategoryController::class);

/** Sub Category routes */
Route::put('subcategories/change-status', [SubCategoryController::class, 'changestatus'])->name('subcategories.change-status');
Route::resource('subcategories',SubCategoryController::class);

/** Child Category routes */
Route::put('child-categories/change-status', [ChildCategoryController::class, 'changestatus'])->name('child-categories.change-status');
Route::resource('child-categories',ChildCategoryController::class);

/** Brand routes */
Route::put('brands/change-status', [BrandController::class, 'changestatus'])->name('brands.change-status');
Route::resource('brands',BrandController::class)->except(['show']);

/** Vendor Profile */
Route::resource('vendor-profile',AdminVendorProfileController::class)->only(['index', 'store']);

/** Products routes */
Route::put('products/change-status', [ProductController::class, 'changestatus'])->name('products.change-status');
Route::resource('products',ProductController::class)->except(['show']);
Route::resource('products.images', ProductImageController::class)->only(['index', 'store', 'destroy']);
Route::resource('products.variants', ProductVariantController::class)->except(['show']);
Route::put('variant/change-status', [ProductVariantController::class, 'changestatus'])->name('products.variants.change-status');
Route::resource('variants.items', ProductVariantItemController::class)->except(['show']);
Route::put('item/change-status', [ProductVariantItemController::class, 'changestatus'])->name('variants.items.change-status');

Route::get('vendor/products', [VendorProductController::class, 'vendorproducts'])->name('vendors.products');
Route::get('vendor/products/pending', [VendorProductController::class, 'pendingvendorproducts'])->name('vendors.products.pending');
Route::put('vendor/products/change-status', [VendorProductController::class, 'changestatus'])->name('vendors.products.change-status');
Route::put('vendor/products/approve', [VendorProductController::class, 'changeapprovestatus'])->name('vendors.products.approve');

/** Flash Sales */
Route::controller(FlashSaleController::class)->group(function(){
    Route::get('flash-sales', 'index')->name('flash-sales.index');
    Route::put('flash-sales', 'update')->name('flash-sales.update');
    Route::post('flash-sales/add-product', 'addproduct')->name('flash-sales.add-product');
    Route::put('flash-sales/change-status', 'changestatus')->name('flash-sales.change-status');
    Route::put('flash-sales/change-home-status', 'changehomestatus')->name('flash-sales.change-home-status');
    Route::delete('flash-sales/delete-product/{item}', 'deleteproduct')->name('flash-sales.delete-product');
    
});

/** General Settings */
Route::controller(SettingController::class)->group(function(){
    Route::get('settings', 'index')->name('settings.index');
    Route::put('general-settings/update', 'generalsettingsupdate')->name('general-settings.update');

});

/** Coupons */
Route::put('coupons/change-status', [CouponController::class, 'changestatus'])->name('coupons.change-status');
Route::resource('coupons', CouponController::class)->except(['show']);

/** Shipping rules */
Route::put('shipping-rules/change-status', [ShippingRuleController::class, 'changestatus'])->name('shipping-rules.change-status');
Route::resource('shipping-rules', ShippingRuleController::class)->except(['show']);

/** Payment Settings */
Route::controller(PaymentController::class)->group(function(){
    Route::get('payment-settings', 'index')->name('payment-settings.index');
    Route::put('paystack-settings/update', 'updatepaystack')->name('paystack-settings.update');
    Route::put('flutterwave-settings/update', 'updateflutterwave')->name('flutterwave-settings.update');

});

/** Orders */
Route::post('orders/change-status', [OrderController::class, 'changeStatus'])->name('orders.change-status');
Route::get('status/orders/{status}', [OrderController::class , 'index'])->name('orders.status');
Route::resource('orders', OrderController::class);

/** Transactions */
Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');

