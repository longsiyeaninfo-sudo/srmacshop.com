<?php

namespace App\Livewire;

use App\Services\CartService;
use Livewire\Attributes\On;
use Livewire\Component;

class CartDrawer extends Component
{
    public bool $isOpen = false;
    public string $couponCode = '';
    public ?string $couponStatus = null;
    public string $paymentMethod = 'cash';

    #[On('cart.add')]
    public function handleAdd(int $productId, int $qty = 1): void
    {
     app(CartService::class)->add($productId, $qty);
     $this->isOpen = true;
     $this->dispatch('cart.updated');
        $this->dispatch('toast', message: __('Added to cart'), type: 'success');
    }

    #[On('cart.open')]
    public function open(): void
    {
        $this->isOpen = true;
    }

    public function close(): void
    {
      $this->isOpen = false;
    }

    public function changeQty(int $productId, int $delta): void
    {
        $cart = app(CartService::class);
        $current = collect($cart->items())->firstWhere('product.id', $productId);
      $cart->update($productId, max(0, ($current['quantity'] ?? 0) + $delta));
        $this->dispatch('cart.updated');
    }

    public function removeItem(int $productId): void
    {
     app(CartService::class)->remove($productId);
        $this->dispatch('cart.updated');
    }

    public function applyCoupon(): void
    {
        $coupon = app(CartService::class)->applyCoupon(strtoupper(trim($this->couponCode)));
        $this->couponStatus = $coupon ? __('Coupon applied') : __('Invalid coupon');
    }

    public function selectPayment(string $method): void
    {
        if (in_array($method, ['cash', 'card', 'qr', 'aba'], true)) {
          $this->paymentMethod = $method;
        }
    }

    public function render()
    {
      $cart = app(CartService::class);
        return view('livewire.cart-drawer', [
            'items' => $cart->items(),
          'subtotal' => $cart->subtotal(),
            'discount' => $cart->discount(),
            'tax' => $cart->tax(),
            'total' => $cart->total(),
        ]);
    }
}
