<?php

namespace App\Http\Controllers;

use App\Models\Category;

class ShopController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('name')->get();

        return view('shop.index', compact('categories'));
    }
}
