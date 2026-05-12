<?php

namespace App\Livewire\Account;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Wishlist extends Component
{
    public function removeFromWishlist($productId)
    {
        Auth::user()->wishlists()->where('product_id', $productId)->delete();

        $this->dispatch('wishlist-updated');
        session()->flash('success', __('Product removed from wishlist'));
    }
    public function addToCart($productId)
    {
        $product = Product::findOrFail($productId);

     // Add to cart logic (reuse from Cart component)
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
              'name' => $product->name,
                'price' => $product->price,
             'image' => $product->getFirstMediaUrl('images'),
                'quantity' => 1,
            ];
        }

        session()->put('cart', $cart);

        $this->dispatch('cart-updated');
      session()->flash('success', __('Product added to cart'));
    }

    public function render()
    {
        $wishlists = Auth::user()->wishlists()->with('product.media')->get();

        return view('livewire.account.wishlist', [
       'wishlists' => $wishlists,
        ]);
    }
}
