<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'name', 'slug', 'spec', 'price', 'original_price', 'sale_ends_at', 'is_flash_deal',
        'emoji', 'category_id', 'stock', 'badge', 'description', 'warranty', 'color', 'weight',
        'is_active', 'sort_order',
    ];

    protected $casts = [
        'price' => 'integer',
        'original_price' => 'integer',
        'sale_ends_at' => 'datetime',
        'is_flash_deal' => 'boolean',
        'stock' => 'integer',
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];

    public function isOnSale(): bool
    {
        return $this->original_price !== null && $this->original_price > $this->price;
    }

    public function discountAmount(): int
    {
        return $this->isOnSale() ? ($this->original_price - $this->price) : 0;
    }

    public function discountPercent(): int
    {
        if (! $this->isOnSale() || ! $this->original_price) {
            return 0;
        }
        return (int) round((1 - $this->price / $this->original_price) * 100);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function priceDollars(): Attribute
    {
        return Attribute::get(fn () => $this->price / 100);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('gallery');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(400)
        ->height(400)
         ->nonQueued();
    }
}
