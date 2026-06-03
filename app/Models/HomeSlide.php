<?php

namespace App\Models;

use App\Models\Concerns\WatermarksImagePath;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class HomeSlide extends Model
{
    use WatermarksImagePath;

    protected $fillable = [
        'product_id',
        'image_path',
        'title_en', 'title_km', 'title_zh',
        'link_url',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'sort_order' => 'integer',
        'product_id' => 'integer',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeActive(Builder $q): Builder
    {
        return $q->where('is_active', true)
            ->where(function ($q) {
                // Custom upload OR linked product (which supplies its own gallery image)
                $q->whereNotNull('image_path')
                  ->orWhereNotNull('product_id');
            })
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    public function imageUrl(): ?string
    {
        if ($this->image_path) {
            return Storage::disk('public')->url($this->image_path);
        }
        // No custom image — fall back to the linked product's first gallery photo
        return $this->product?->getFirstMediaUrl('gallery') ?: null;
    }

    public function resolvedTitle(): ?string
    {
        return $this->title_en ?: ($this->product?->name);
    }

    public function resolvedPriceCents(): ?int
    {
        return $this->product?->price;
    }

    public function resolvedOriginalPriceCents(): ?int
    {
        $orig = $this->product?->original_price;
        $price = $this->product?->price;
        return ($orig && $price && $orig > $price) ? $orig : null;
    }

    public function resolvedDiscountPercent(): ?int
    {
        return $this->product?->isOnSale() ? $this->product->discountPercent() : null;
    }

    public function resolvedSavingsCents(): ?int
    {
        return $this->product?->isOnSale() ? $this->product->discountAmount() : null;
    }

    public function resolvedCategoryName(): ?string
    {
        return $this->product?->category?->name;
    }

    public function resolvedUrl(): ?string
    {
        if ($this->link_url) {
            return $this->link_url;
        }
        return $this->product ? route('product', $this->product->slug) : null;
    }
}
