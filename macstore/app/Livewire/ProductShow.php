<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\ProductVariant;
use Livewire\Component;

class ProductShow extends Component
{
    public Product $product;
    public $selectedVariantId;
    public $quantity = 1;

    public function mount($slug)
    {
        $this->product = Product::with(['category', 'variants', 'specs', 'media'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Select first available variant
        $this->selectedVariantId = $this->product->variants()->where('is_active', true)->first()?->id;
    }

    public function getSelectedVariantProperty()
    {
        return ProductVariant::find($this->selectedVariantId);
    }

    public function getFinalPriceProperty()
    {
        if (!$this->selectedVariant) {
            return $this->product->sale_price ?? $this->product->base_price;
        }

        $basePrice = $this->product->sale_price ?? $this->product->base_price;
        return $basePrice + $this->selectedVariant->price_modifier;
    }

    public function addToCart()
    {
        if (!$this->selectedVariant) {
        session()->flash('error', __('Please select a variant'));
            return;
     }

        // Cart functionality will be implemented in Phase 6
        session()->flash('success', __('Product added to cart!'));
        $this->dispatch('product-added-to-cart');
    }

    public function render()
    {
    $relatedProducts = Product::where('category_id', $this->product->category_id)
        ->where('id', '!=', $this->product->id)
            ->where('is_active', true)
            ->limit(4)
            ->get();

        return view('livewire.product-show', [
            'relatedProducts' => $relatedProducts,
        ]);
    }
}
