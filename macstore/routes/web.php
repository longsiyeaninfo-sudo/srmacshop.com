<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\ProductsIndex;
use App\Livewire\ProductShow;
use App\Livewire\Cart;
use App\Livewire\Home;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');

// Products
Route::get('/products', ProductsIndex::class)->name('products.index');
Route::get('/products/{slug}', ProductShow::class)->name('products.show');

// Cart
Route::get('/cart', Cart::class)->name('cart');

// Account (requires authentication)
Route::middleware('auth')->prefix('account')->name('account.')->group(function () {
    Route::get('/', \App\Livewire\Account\Dashboard::class)->name('dashboard');
    Route::get('/orders', \App\Livewire\Account\Orders::class)->name('orders');
    Route::get('/addresses', \App\Livewire\Account\Addresses::class)->name('addresses');
    Route::get('/wishlist', \App\Livewire\Account\Wishlist::class)->name('wishlist');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
