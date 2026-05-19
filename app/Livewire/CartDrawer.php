<?php

namespace App\Livewire;

use App\Models\Setting;
use App\Services\CartService;
use Livewire\Attributes\On;
use Livewire\Component;

class CartDrawer extends Component
{
    public bool $isOpen = false;
    public string $couponCode = '';
    public ?string $couponStatus = null;
    public string $paymentMethod = 'cash';
    public bool $isProvince = false;

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
        $pm = Setting::get('payment_methods', []);
        $allowed = [];
        if (! empty($pm['cash_enabled']))    { $allowed[] = 'cash'; }
        if (! empty($pm['aba_qr_enabled']))  { $allowed[] = 'aba'; $allowed[] = 'qr'; }
        if (! empty($pm['card_enabled']))    { $allowed[] = 'card'; }

        if (empty($allowed) || in_array($method, $allowed, true)) {
            $this->paymentMethod = $method;
        }
    }

    public function setLocation(bool $isProvince): void
    {
        $this->isProvince = $isProvince;
        app(CartService::class)->setIsProvince($isProvince);
    }

    public function render()
    {
        $cart = app(CartService::class);
        $cart->setIsProvince($this->isProvince);

        $pm = Setting::get('payment_methods', []);
        $ts = Setting::get('tax_shipping', []);

        $cashEnabled   = empty($pm) || ! empty($pm['cash_enabled']);
        $abaEnabled    = empty($pm) || ! empty($pm['aba_qr_enabled']);
        $cardEnabled   = ! empty($pm['card_enabled']);
        $taxEnabled    = empty($ts) || ! empty($ts['tax_enabled']);
        $taxPercent    = (float) ($ts['tax_percent'] ?? 10);

        $freeThreshold = 0;
        if (! empty($ts['free_delivery_enabled']) && ! empty($ts['free_delivery_threshold'])) {
            $freeThreshold = (int) ($ts['free_delivery_threshold'] * 100);
        }

        // Ensure selected method is still enabled
        $anyEnabled = $cashEnabled || $abaEnabled || $cardEnabled;
        if ($anyEnabled) {
            if ($this->paymentMethod === 'cash' && ! $cashEnabled) {
                $this->paymentMethod = $abaEnabled ? 'aba' : 'card';
            } elseif (in_array($this->paymentMethod, ['aba', 'qr']) && ! $abaEnabled) {
                $this->paymentMethod = $cashEnabled ? 'cash' : 'card';
            }
        }

        return view('livewire.cart-drawer', [
            'items'         => $cart->items(),
            'subtotal'      => $cart->subtotal(),
            'discount'      => $cart->discount(),
            'tax'           => $cart->tax(),
            'deliveryFee'   => $cart->deliveryFee(),
            'total'         => $cart->total(),
            'cashEnabled'   => $cashEnabled,
            'abaEnabled'    => $abaEnabled,
            'cardEnabled'   => $cardEnabled,
            'taxEnabled'    => $taxEnabled,
            'taxPercent'    => $taxPercent,
            'freeThreshold' => $freeThreshold,
            'abaName'       => $pm['aba_account_name']   ?? 'SR MAC SHOP',
            'abaNumber'     => $pm['aba_account_number'] ?? '000 123 456',
            'abaQrUrl'      => $pm['aba_qr_image_url']   ?? '',
        ]);
    }
}
