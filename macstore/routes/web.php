<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\ProductsIndex;
use App\Livewire\ProductShow;
use App\Livewire\Cart;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

// Products
Route::get('/products', ProductsIndex::class)->name('products.index');
Route::get('/products/{slug}', ProductShow::class)->name('products.show');

// Cart
Route::get('/cart', Cart::class)->name('cart');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
