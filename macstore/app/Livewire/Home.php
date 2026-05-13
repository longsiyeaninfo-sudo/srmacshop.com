<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Category;
use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        $featuredProducts = Product::with(['media', 'category'])
            ->where('is_featured', true)
            ->where('is_active', true)
            ->limit(6)
            ->get();

        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
          ->limit(6)
        ->get();

        return view('livewire.home', [
            'featuredProducts' => $featuredProducts,
            'categories' => $categories,
        ]);
    }
}
