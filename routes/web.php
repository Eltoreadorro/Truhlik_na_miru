<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController as Controller;
use App\Http\Controllers\CheckoutController;
use App\Models\ProductVariant;
use App\Http\Controllers\AdminController;



Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [Controller::class, 'index'])->name('products.index');
Route::get('/products/load', [ProductController::class, 'loadMore'])->name('products.load');
Route::get('/products/{product}', [Controller::class, 'show'])->name('products.show');
Route::get('/contacts', [PageController::class, 'contacts'])->name('contacts');
Route::get('/variants/{variant}', function(ProductVariant $variant) {
    return response()->json([
        'id' => $variant->id,
        'price' => $variant->price,
        'volume' => $variant->volume,
        'color' => $variant->color,
        'image' => asset('storage/' . ($variant->image ?? $variant->product->image))
    ]);
});
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add/{variant}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/update/{variant}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/remove/{variant}', [CartController::class, 'remove'])->name('cart.remove');
});
// routes/web.php


Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');


// Админ-роуты
Route::prefix('admin')->name('admin.')->group(function () {
    // Группа с проверкой auth и admin роли
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');

        // Ресурсные маршруты
        Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    });
    // Пользователи (будет позже)
    // Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->only(['index']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
