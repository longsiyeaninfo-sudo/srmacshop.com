<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function getCart()
    {
      if (Auth::check()) {
          return Cart::firstOrCreate(
                ['user_id' => Auth::id()],
                ['session_id' => null]
            );
        }

     $sessionId = Session::getId();
     return Cart::firstOrCreate(
            ['session_id' => $sessionId],
            ['user_id' => null]
        );
    }

    public function addItem(int $variantId, int $quantity = 1)
    {
        $cart = $this->getCart();
        $variant = ProductVariant::with('product')->findOrFail($variantId);

        // Check stock
        if ($variant->stock_quantity < $quantity) {
          throw new \Exception('Insufficient stock');
        }

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_variant_id', $variantId)
            ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $quantity;
         if ($variant->stock_quantity < $newQuantity) {
                throw new \Exception('Insufficient stock');
        }
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
          $price = $variant->product->sale_price ?? $variant->product->base_price;
            $price += $variant->price_modifier;

            CartItem::create([
          'cart_id' => $cart->id,
          'product_variant_id' => $variantId,
                'quantity' => $quantity,
                'price_at_add' => $price,
        ]);
        }

        return $cart->fresh('items.productVariant.product');
    }

    public function updateQuantity(int $cartItemId, int $quantity)
    {
        $cart = $this->getCart();
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->findOrFail($cartItemId);

        if ($quantity <= 0) {
            $cartItem->delete();
        } else {
         $variant = $cartItem->productVariant;
            if ($variant->stock_quantity < $quantity) {
             throw new \Exception('Insufficient stock');
            }
            $cartItem->update(['quantity' => $quantity]);
        }

        return $cart->fresh('items.productVariant.product');
    }

    public function removeItem(int $cartItemId)
    {
        $cart = $this->getCart();
        CartItem::where('cart_id', $cart->id)
            ->where('id', $cartItemId)
        ->delete();

        return $cart->fresh('items.productVariant.product');
    }

    public function getCartTotal()
    {
        $cart = $this->getCart();
        return $cart->items->sum(function ($item) {
            return $item->price_at_add * $item->quantity;
        });
    }

    public function getCartCount()
    {
        $cart = $this->getCart();
        return $cart->items->sum('quantity');
    }

    public function clearCart()
    {
        $cart = $this->getCart();
        $cart->items()->delete();
    }

    public function mergeCarts()
    {
        if (!Auth::check()) {
            return;
        }

        $sessionId = Session::getId();
        $sessionCart = Cart::where('session_id', $sessionId)->first();

     if (!$sessionCart || $sessionCart->items->isEmpty()) {
            return;
        }

        $userCart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        foreach ($sessionCart->items as $item) {
            $existingItem = $userCart->items()
                ->where('product_variant_id', $item->product_variant_id)
                ->first();

            if ($existingItem) {
              $existingItem->update([
               'quantity' => $existingItem->quantity + $item->quantity
                ]);
         } else {
                $item->update(['cart_id' => $userCart->id]);
         }
        }

        $sessionCart->delete();
    }
}
