<?php

namespace App\Livewire;

use App\Services\CartService;
use Livewire\Component;
use Livewire\Attributes\On;

class CartCounter extends Component
{
    public $count = 0;

    public function mount()
    {
        $this->updateCount();
    }

    #[On('cart-updated')]
    public function updateCount()
    {
      $cartService = app(CartService::class);
        $this->count = $cartService->getCartCount();
    }

    public function render()
    {
        return view('livewire.cart-counter');
    }
}
