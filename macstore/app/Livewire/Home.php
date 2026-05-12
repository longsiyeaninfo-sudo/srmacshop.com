<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Category;
use Livewire\Component;
use Illuminate\Support\Facades\Cache;

class Home extends Component
{
    public function render()
    {
        // Cache featured products for 1 hour
        $featuredProducts = Cache::remember('featured_products', 3600, function () {
            return Product::with(['media', 'category'])
                ->where('is_featured', true)
                ->where('is_active', true)
             ->limit(6)
         ->get();
        });

        // Cache categories for 1 hour
        $categories = Cache::remember('active_categories', 3600, function () {
            return Category::where('is_active', true)
             ->orderBy('sort_order')
                ->limit(6)
                ->get();
        });

        return view('livewire.home', [
            'featuredProducts' => $featuredProducts,
            'categories' => $categories,
        ]);
    }
}
