<?php

use App\Http\Controllers\Customer\MidtransController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Customer\ProductController as CustomerProductController;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/products-list', [CustomerProductController::class, 'index'])->name('customer.products.index');
    Route::post('/add-to-cart/{product}', [CustomerProductController::class, 'addToCart'])->name('customer.add_to_cart');
    Route::get('/cart', [CustomerProductController::class, 'cart'])->name('customer.cart');
    Route::get('/checkout', [CustomerProductController::class, 'checkout'])->name('customer.checkout');
    Route::post('/midtrans/notification', [MidtransController::class, 'notificationHandler']);
    Route::get('/payment-success/{order_id}', [MidtransController::class, 'paymentSuccess'])->name('customer.payment_success');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
    Route::get('/products', [ProductController::class, 'index'])->name('admin.products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('admin.products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('admin.products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('admin.products.destroy');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('admin.products.show');

    Route::post('/products/{product}/toggle-status', [ProductController::class, 'toggleStatus'])->name('admin.products.toggleStatus');
});

require __DIR__.'/auth.php';
