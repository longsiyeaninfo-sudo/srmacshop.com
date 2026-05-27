<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class HomeSlide extends Model
{
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
            ->whereNotNull('image_path')
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    public function imageUrl(): ?string
    {
        return $this->image_path
            ? Storage::disk('public')->url($this->image_path)
            : null;
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

    public function resolvedUrl(): ?string
    {
        if ($this->link_url) {
            return $this->link_url;
        }
        return $this->product ? route('product', $this->product->slug) : null;
    }
}
