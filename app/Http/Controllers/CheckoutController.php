<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\CartService;
use App\Services\CheckoutService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function process(Request $request, CheckoutService $checkout): RedirectResponse
    {
        $data = $request->validate([
       'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:50'],
            'customer_address' => ['required', 'string', 'max:1000'],
            'payment_method' => ['required', 'in:cash,card,qr,aba'],
            'notes' => ['nullable', 'string', 'max:2000'],
      ]);

      $cart = app(CartService::class);
        if ($cart->itemCount() === 0) {
            return redirect()->route('shop')->with('error', __('Your cart is empty.'));
        }

        $order = DB::transaction(fn () => $checkout->place($cart, $data));

        if ($data['payment_method'] === 'card') {
            return $checkout->stripeCheckout($order);
        }

        $cart->clear();

      return redirect()->route('checkout.success', $order);
    }

    public function success(Order $order)
    {
        $order->load('items');
      return view('checkout.success', compact('order'));
    }
}
