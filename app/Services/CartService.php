<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class CartService
{
    private const SESSION_KEY = 'cart';
    private const COUPON_KEY = 'cart_coupon';
    private const TAX_RATE = 0.10; // 10%

    /** @return Collection<int, array{product: Product, quantity: int, line_total: int}> */
    public function items(): Collection
    {
        $cart = $this->raw();
        if (empty($cart)) {
            return collect();
        }

        $products = Product::with('media')
            ->whereIn('id', array_keys($cart))
            ->get()
            ->keyBy('id');

        return collect($cart)
          ->filter(fn ($qty, $id) => $products->has($id))
            ->map(fn ($qty, $id) => [
                'product' => $products[$id],
                'quantity' => (int) $qty,
           'line_total' => (int) ($products[$id]->price * (int) $qty),
            ])
            ->values();
    }

    public function add(int $productId, int $qty = 1): void
    {
        $product = Product::where('is_active', true)->findOrFail($productId);
        $cart = $this->raw();
        $current = (int) ($cart[$productId] ?? 0);
        $newQty = max(1, min($product->stock, $current + $qty));
        $cart[$productId] = $newQty;
        Session::put(self::SESSION_KEY, $cart);
    }

    public function update(int $productId, int $qty): void
    {
        $cart = $this->raw();
        if ($qty <= 0) {
            unset($cart[$productId]);
        } else {
        $product = Product::find($productId);
            $cart[$productId] = $product ? min($product->stock, $qty) : $qty;
        }
        Session::put(self::SESSION_KEY, $cart);
    }

    public function remove(int $productId): void
    {
        $cart = $this->raw();
        unset($cart[$productId]);
        Session::put(self::SESSION_KEY, $cart);
    }

    public function clear(): void
    {
     Session::forget([self::SESSION_KEY, self::COUPON_KEY]);
    }

    public function itemCount(): int
    {
        return array_sum($this->raw());
  }

    public function subtotal(): int
    {
        return (int) $this->items()->sum('line_total');
    }

    public function applyCoupon(string $code): ?Coupon
    {
      $coupon = Coupon::where('code', $code)->first();
        if (! $coupon || ! $coupon->isValid($this->subtotal())) {
            Session::forget(self::COUPON_KEY);
            return null;
        }
        Session::put(self::COUPON_KEY, $coupon->code);
        return $coupon;
    }

    public function coupon(): ?Coupon
    {
      $code = Session::get(self::COUPON_KEY);
        return $code ? Coupon::where('code', $code)->first() : null;
    }

    public function discount(): int
    {
        $coupon = $this->coupon();
        if (! $coupon) {
         return 0;
        }
      return $coupon->apply($this->subtotal());
    }

  public function tax(): int
  {
        return (int) round(($this->subtotal() - $this->discount()) * self::TAX_RATE);
    }

    public function total(): int
    {
        return max(0, $this->subtotal() - $this->discount() + $this->tax());
    }

    /** @return array<int, int> */
    private function raw(): array
    {
        return Session::get(self::SESSION_KEY, []);
    }
}
