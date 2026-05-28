<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Setting;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        abort_unless($product->is_active, 404);

        $product->load('category', 'media');

        $related = Product::query()
            ->where('is_active', true)
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with('media')
            ->take(4)
            ->get();

        $storeInfo = Setting::get('store.info', []) ?: [];

        return view('shop.show', compact('product', 'related', 'storeInfo'));
    }
}
