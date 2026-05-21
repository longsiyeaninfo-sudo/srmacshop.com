<?php

namespace App\Livewire;

use App\Models\Category;
use App\Services\CartService;
use Livewire\Attributes\On;
use Livewire\Component;

class Nav extends Component
{
    public function render()
    {
        return view('livewire.nav', [
            'cartCount' => app(CartService::class)->itemCount(),
            'navCategories' => Category::ordered()
                ->withCount(['products' => fn ($q) => $q->where('is_active', true)])
                ->take(8)
                ->get(),
        ]);
    }

    #[On('cart.updated')]
    public function refreshCount(): void
    {
        // re-render via event from CartDrawer
    }
}
