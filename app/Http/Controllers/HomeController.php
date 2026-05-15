<?php

namespace App\Http\Controllers;

use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
      $featured = Product::query()
            ->where('is_active', true)
        ->whereIn('badge', ['new', 'hot'])
            ->with('media')
          ->take(4)
          ->get();

        return view('home', compact('featured'));
    }
}
