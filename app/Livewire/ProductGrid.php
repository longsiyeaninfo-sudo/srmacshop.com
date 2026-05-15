<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ProductGrid extends Component
{
    use WithPagination;

    #[Url(as: 'q', except: '')]
    public string $search = '';

    #[Url(except: '')]
    public string $category = '';

    public $categories;

    public function mount($categories = null): void
    {
        $this->categories = $categories ?? \App\Models\Category::orderBy('name')->get();
    }

    public function updatedSearch(): void
    {
      $this->resetPage();
    }

    public function updatedCategory(): void
    {
        $this->resetPage();
    }

    public function render()
    {
     $products = Product::query()
      ->where('is_active', true)
            ->when($this->search, fn ($q) => $q->where('name', 'like', '%'.$this->search.'%'))
            ->when($this->category, function ($q) {
             $q->whereHas('category', fn ($c) => $c->where('slug', $this->category));
        })
            ->with('media', 'category')
            ->orderBy('sort_order')
            ->paginate(12);

        return view('livewire.product-grid', compact('products'));
    }
}
