<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CompareController extends Controller
{
    public function show(Request $request)
    {
        $ids = collect(explode(',', (string) $request->query('ids', '')))
            ->map(fn ($v) => (int) trim($v))
            ->filter()
            ->unique()
            ->take(4)
            ->values()
            ->all();

        $products = Product::with(['media', 'category'])
            ->where('is_active', true)
            ->whereIn('id', $ids)
            ->get()
            ->sortBy(fn ($p) => array_search($p->id, $ids))
            ->values();

        return view('compare', compact('products'));
    }
}
