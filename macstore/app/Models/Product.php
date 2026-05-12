<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Product extends Model implements HasMedia
{
    use InteractsWithMedia, HasTranslations;

    protected $fillable = [
        'category_id', 'name', 'slug', 'sku_prefix',
        'short_description', 'description', 'base_price', 'sale_price',
        'condition', 'is_featured', 'is_active',
        'meta_title', 'meta_description'
    ];

    public $translatable = ['name', 'short_description', 'description', 'meta_title', 'meta_description'];

    protected $casts = [
        'base_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function specs(): HasMany
    {
        return $this->hasMany(ProductSpec::class);
    }

    public function reviews(): HasMany
    {
     return $this->hasMany(Review::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images')
            ->useFallbackUrl('/images/placeholder-macbook.png');
    }
}
