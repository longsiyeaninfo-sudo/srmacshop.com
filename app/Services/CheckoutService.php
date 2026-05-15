<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Mail\OrderConfirmation;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class CheckoutService
{
    public function place(CartService $cart, array $customer): Order
    {
        $items = $cart->items();
      if ($items->isEmpty()) {
      abort(422, 'Cart is empty.');
      }

        // Server-side stock revalidation
        foreach ($items as $item) {
            /** @var Product $product */
            $product = Product::lockForUpdate()->find($item['product']->id);
            if (! $product || ! $product->is_active || $product->stock < $item['quantity']) {
           abort(422, 'A product in your cart is out of stock.');
        }
        }

        $coupon = $cart->coupon();

        $order = Order::create([
         'order_number' => 'TMP', // replaced by booted hook after id assigned
        'customer_name' => $customer['customer_name'],
            'customer_phone' => $customer['customer_phone'],
        'customer_address' => $customer['customer_address'],
            'payment_method' => $customer['payment_method'],
        'subtotal' => $cart->subtotal(),
            'discount' => $cart->discount(),
     'tax' => $cart->tax(),
         'total' => $cart->total(),
            'coupon_code' => $coupon?->code,
      'status' => OrderStatus::Pending,
            'notes' => $customer['notes'] ?? null,
        ]);

      foreach ($items as $item) {
        $product = $item['product'];
         OrderItem::create([
            'order_id' => $order->id,
           'product_id' => $product->id,
                'product_name_snapshot' => $product->name,
              'product_spec_snapshot' => $product->spec,
            'unit_price' => $product->price,
        'quantity' => $item['quantity'],
                'line_total' => $item['line_total'],
            ]);

            $product->decrement('stock', $item['quantity']);
        }

      if ($coupon) {
            $coupon->increment('used_count');
      }

        if ($customer['payment_method'] !== 'card') {
            $this->notifyCustomer($order);
        }

        return $order->refresh();
    }

  public function stripeCheckout(Order $order): RedirectResponse
    {
        // TODO: build Stripe Cashier checkout session here
        // For now, mark as pending and return to success page.
       return redirect()->route('checkout.success', $order);
    }

    public function notifyCustomer(Order $order): void
    {
        if (config('mail.default') === 'log' || ! filter_var($order->customer_phone, FILTER_VALIDATE_EMAIL)) {
            // No customer email captured yet — skip silently.
            return;
    }
      Mail::to($order->customer_phone)->send(new OrderConfirmation($order));
    }
}
