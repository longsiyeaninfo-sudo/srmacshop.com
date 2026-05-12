<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class ProductsIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $categoryFilter = '';
    public $conditionFilter = '';
    public $sortBy = 'latest';
    public $minPrice = 0;
    public $maxPrice = 5000;

    protected $queryString = [
        'search' => ['except' => ''],
        'categoryFilter' => ['except' => '', 'as' => 'category'],
        'conditionFilter' => ['except' => '', 'as' => 'condition'],
    'sortBy' => ['except' => 'latest', 'as' => 'sort'],
    ];
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategoryFilter()
    {
        $this->resetPage();
    }
    public function updatingConditionFilter()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset(['search', 'categoryFilter', 'conditionFilter', 'minPrice', 'maxPrice']);
        $this->resetPage();
    }

    public function render()
    {
        $query = Product::with(['category', 'media'])
            ->where('is_active', true);

        // Search
        if ($this->search) {
        $query->where(function ($q) {
                $q->where('name->en', 'like', '%' . $this->search . '%')
                ->orWhere('name->km', 'like', '%' . $this->search . '%')
                  ->orWhere('slug', 'like', '%' . $this->search . '%');
            });
      }

        // Category filter
        if ($this->categoryFilter) {
          $query->where('category_id', $this->categoryFilter);
        }

        // Condition filter
      if ($this->conditionFilter) {
            $query->where('condition', $this->conditionFilter);
        }

        // Price range
        $query->whereBetween('base_price', [$this->minPrice, $this->maxPrice]);

        // Sorting
        switch ($this->sortBy) {
            case 'price_low':
                $query->orderBy('base_price', 'asc');
                break;
        case 'price_high':
             $query->orderBy('base_price', 'desc');
                break;
         case 'name':
                $query->orderBy('name->en', 'asc');
             break;
            default:
                $query->latest();
        }

      $products = $query->paginate(12);
        $categories = Category::where('is_active', true)->get();

        return view('livewire.products-index', [
            'products' => $products,
         'categories' => $categories,
        ]);
    }
}
