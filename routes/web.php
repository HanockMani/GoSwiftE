<?php

use App\Http\Controllers\Admin\AdminMainController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductAttributeController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductDiscountController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Customer\CustomerMainController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Seller\SellerMainController;
use App\Http\Controllers\Seller\SellerProductController;
use App\Http\Controllers\Seller\SellerStoreController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//admin route groups
Route::middleware(['auth', 'verified', 'rolemanager:admin'])->group(function () {
    Route::prefix('admin')->group(function() {
        Route::controller(AdminMainController::class)->group(function() {
            Route::get('/dashboard', 'index')->name('admin');
            Route::get('/setting', 'setting')->name('admin.setting');
            Route::get('/manage/user', 'manage_user')->name('admin.manage.user');
            Route::get('/manage/store', 'manage_store')->name('admin.manage.store');
            Route::get('/cart/history', 'cart_history')->name('admin.cart.history');
            Route::get('/order/history', 'order_history')->name('admin.order.history');
        });

        Route::controller(CategoryController::class)->group(function() {
            Route::get('/category/create', 'index')->name('category.create');
            Route::get('/category/manage', 'manage')->name('category.manage');
        });

        Route::controller(SubCategoryController::class)->group(function() {
            Route::get('/subcategory/create', 'index')->name('subcategory.create');
            Route::get('/subcategory/manage', 'manage')->name('subcategory.manage');
        });

        Route::controller(ProductController::class)->group(function() {
            Route::get('/product/manage', 'index')->name('product.manage');
            Route::get('/product/review/manage', 'review_manage')->name('product.review.manage');
        });

        Route::controller(ProductAttributeController::class)->group(function() {
            Route::get('/productattribute/create', 'index')->name('productattribute.create');
            Route::get('/productattribute/manage', 'manage')->name('productattribute.manage');
        });

        Route::controller(ProductDiscountController::class)->group(function() {
            Route::get('/discount/create', 'index')->name('discount.create');
            Route::get('/discount/manage', 'manage')->name('discount.manage');
        });

    });
});

//seller route groups
Route::middleware(['auth', 'verified', 'rolemanager:seller'])->group(function () {
    Route::prefix('seller')->group(function() {
        Route::controller(SellerMainController::class)->group(function() {
            Route::get('/dashboard', 'index')->name('seller');
            Route::get('/order/history', 'orderhistory')->name('seller.order.history');
        });

        Route::controller(SellerProductController::class)->group(function() {
            Route::get('/product/create', 'index')->name('seller.product');
            Route::get('/product/manage', 'manage')->name('seller.product.manage');
        });

        Route::controller(SellerStoreController::class)->group(function() {
            Route::get('/store/create', 'index')->name('seller.store');
            Route::get('/store/manage', 'manage')->name('seller.store.manage');
        });

    });
});

//customer route groups
Route::middleware(['auth', 'verified', 'rolemanager:customer'])->group(function () {
    Route::prefix('customer')->group(function() {
        Route::controller(CustomerMainController::class)->group(function() {
            Route::get('/dashboard', 'index')->name('dashboard');
            Route::get('/order/history', 'history')->name('customer.history');
            Route::get('/settings/payment', 'payment')->name('customer.payment');
            Route::get('/affiliate', 'affiliate')->name('customer.affiliate');
        });
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
