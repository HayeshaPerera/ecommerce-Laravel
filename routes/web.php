<?php

use App\Http\Controllers\AuthManager;
use App\Http\Controllers\OrderManager;
use App\Http\Controllers\ProductsManager;
use App\Http\Controllers\NewsletterController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductsManager::class, 'index'])->name('home');

// Login Routes
Route::get("login", [AuthManager::class, "login"])->name("login");
Route::get("logout", [AuthManager::class, "logout"])->name("logout");
Route::post("login", [AuthManager::class, "loginPost"])->name("login.post");

// Registration Routes
Route::get("register", [AuthManager::class, "register"])->name("register");
Route::post("register", [AuthManager::class, "registerPost"])->name("register.post");

// Product details route
Route::get('/product/{slug}', [ProductsManager::class, 'details'])->name('products.details');

Route::middleware('web')->group(function () {
    Route::post('/cart/add/{id}', [ProductsManager::class, 'addToCart'])->name('cart.add');

    Route::get('/cart', [ProductsManager::class, 'showCart'])->name('cart.show');
    Route::delete('/cart/{product_id}', [ProductsManager::class, 'removeFromCart'])->name('cart.remove');
    // Use PUT for updating the product quantity in the cart
Route::put('/cart/{product_id}/update', [ProductsManager::class, 'updateCart'])->name('cart.update');


    Route::get('/checkout', [OrderManager::class, 'showCheckout'])->name('checkout.show');
    Route::post('/checkout', [OrderManager::class, 'checkoutPost'])->name('checkout.post');

    // Newsletter Subscription Route
    Route::post('newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
});
