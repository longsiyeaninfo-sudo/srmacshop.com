<?php

namespace App\Http\Controllers;

use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        // Show badged products first, then by sort_order — total 8 featured
        $featured = Product::query()
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->with('media', 'category')
            ->orderByRaw("CASE WHEN badge IN ('new','hot','sale') THEN 0 ELSE 1 END")
            ->orderBy('sort_order')
            ->take(8)
            ->get();

        return view('home', compact('featured'));
    }
}
