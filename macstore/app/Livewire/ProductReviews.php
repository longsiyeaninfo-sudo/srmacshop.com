<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProductReviews extends Component
{
    public Product $product;
    public $rating = 5;
    public $comment = '';
    public $showForm = false;

    protected $rules = [
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'required|string|min:10|max:1000',
    ];

    public function mount(Product $product)
    {
      $this->product = $product;
    }

    public function toggleForm()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $this->showForm = !$this->showForm;
    }

    public function submitReview()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $this->validate();

        // Check if user already reviewed this product
     $existingReview = Review::where('product_id', $this->product->id)
         ->where('user_id', Auth::id())
            ->first();

        if ($existingReview) {
            session()->flash('error', __('You have already reviewed this product'));
            return;
        }

        Review::create([
         'product_id' => $this->product->id,
            'user_id' => Auth::id(),
            'rating' => $this->rating,
      'comment' => $this->comment,
            'is_approved' => false,
        ]);

        $this->reset(['rating', 'comment', 'showForm']);
        $this->rating = 5;

        session()->flash('success', __('Review submitted successfully. It will be visible after approval.'));
    }

    public function render()
    {
        $reviews = $this->product->reviews()
            ->where('is_approved', true)
            ->with('user')
            ->latest()
            ->get();

        $averageRating = $reviews->avg('rating');
        $ratingCounts = [
          5 => $reviews->where('rating', 5)->count(),
            4 => $reviews->where('rating', 4)->count(),
            3 => $reviews->where('rating', 3)->count(),
         2 => $reviews->where('rating', 2)->count(),
          1 => $reviews->where('rating', 1)->count(),
        ];

        return view('livewire.product-reviews', [
            'reviews' => $reviews,
            'averageRating' => $averageRating,
            'ratingCounts' => $ratingCounts,
        ]);
    }
}
