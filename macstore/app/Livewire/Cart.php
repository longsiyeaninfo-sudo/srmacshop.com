<?php

namespace App\Livewire;

use App\Services\CartService;
use Livewire\Component;

class Cart extends Component
{
    protected $cartService;

    public function boot(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function updateQuantity($cartItemId, $quantity)
    {
        try {
            $this->cartService->updateQuantity($cartItemId, $quantity);
            $this->dispatch('cart-updated');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function removeItem($cartItemId)
    {
        $this->cartService->removeItem($cartItemId);
        $this->dispatch('cart-updated');
        session()->flash('success', __('Item removed from cart'));
    }

    public function render()
    {
        $cart = $this->cartService->getCart();
        $cart->load('items.productVariant.product.media');
        
        $subtotal = $this->cartService->getCartTotal();
        $shipping = 0; // Will be calculated in checkout
     $tax = 0; // Will be calculated in checkout
        $total = $subtotal + $shipping + $tax;

     return view('livewire.cart', [
            'cart' => $cart,
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'tax' => $tax,
          'total' => $total,
        ]);
    }
}
