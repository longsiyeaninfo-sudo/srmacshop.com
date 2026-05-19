<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class CartService
{
    private const SESSION_KEY = 'cart';
    private const COUPON_KEY = 'cart_coupon';
    private const LOCATION_KEY = 'cart_location'; // 'pp' | 'province'

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
                'product'   => $products[$id],
                'quantity'  => (int) $qty,
                'line_total'=> (int) ($products[$id]->price * (int) $qty),
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
        Session::forget([self::SESSION_KEY, self::COUPON_KEY, self::LOCATION_KEY]);
    }

    public function itemCount(): int
    {
        return array_sum($this->raw());
    }

    // ── Coupon ──────────────────────────────────────────────────────────────

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

    // ── Location (affects delivery fee) ─────────────────────────────────────

    public function setIsProvince(bool $isProvince): void
    {
        Session::put(self::LOCATION_KEY, $isProvince ? 'province' : 'pp');
    }

    public function isProvince(): bool
    {
        return Session::get(self::LOCATION_KEY, 'pp') === 'province';
    }

    // ── Totals ───────────────────────────────────────────────────────────────

    public function subtotal(): int
    {
        return (int) $this->items()->sum('line_total');
    }

    public function discount(): int
    {
        $coupon = $this->coupon();
        return $coupon ? $coupon->apply($this->subtotal()) : 0;
    }

    public function tax(): int
    {
        $settings = Setting::get('tax_shipping', []);
        if (isset($settings['tax_enabled']) && ! $settings['tax_enabled']) {
            return 0;
        }
        $rate = (float) ($settings['tax_percent'] ?? 10) / 100;
        return (int) round(($this->subtotal() - $this->discount()) * $rate);
    }

    public function deliveryFee(): int
    {
        $settings = Setting::get('tax_shipping', []);
        $subtotal = $this->subtotal();

        // Free delivery threshold
        if (! empty($settings['free_delivery_enabled']) && $settings['free_delivery_enabled']) {
            $threshold = (int) (($settings['free_delivery_threshold'] ?? 500) * 100);
            if ($subtotal >= $threshold) {
                return 0;
            }
        }

        if ($this->isProvince()) {
            return (int) (($settings['province_delivery_fee'] ?? 10) * 100);
        }

        return (int) (($settings['default_delivery_fee'] ?? 5) * 100);
    }

    public function total(): int
    {
        return max(0, $this->subtotal() - $this->discount() + $this->tax() + $this->deliveryFee());
    }

    /** @return array<int, int> */
    private function raw(): array
    {
        return Session::get(self::SESSION_KEY, []);
    }
}
