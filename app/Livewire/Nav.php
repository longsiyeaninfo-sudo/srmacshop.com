<?php

namespace App\Livewire;

use App\Services\CartService;
use Livewire\Attributes\On;
use Livewire\Component;

class Nav extends Component
{
    public function render()
    {
        return view('livewire.nav', [
          'cartCount' => app(CartService::class)->itemCount(),
        ]);
    }

    #[On('cart.updated')]
    public function refreshCount(): void
    {
        // re-render via event from CartDrawer
    }
}
