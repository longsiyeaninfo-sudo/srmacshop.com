<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CompareController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\StripeWebhookController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/shop/{product:slug}', [ProductController::class, 'show'])->name('product');
Route::get('/compare', [CompareController::class, 'show'])->name('compare');
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');

Route::post('/checkout', [CheckoutController::class, 'process'])
    ->middleware('throttle:5,1')
    ->name('checkout.process');
Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])
    ->name('checkout.success');

Route::get('/invoice/{order}', [InvoiceController::class, 'show'])->name('invoice');

Route::post('/webhooks/stripe', [StripeWebhookController::class, 'handle'])
    ->name('webhooks.stripe');

Route::get('/track-order', fn () => view('track-order'))->name('track-order');

Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
