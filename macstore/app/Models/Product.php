<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

class Product extends Model implements HasMedia
{
    use InteractsWithMedia, HasTranslations, Searchable;

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

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'short_description' => $this->short_description,
            'description' => $this->description,
            'sku_prefix' => $this->sku_prefix,
            'category_name' => $this->category?->name,
        ];
    }

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
            ->useFallbackUrl('/images/placeholder-macbook.png')
            ->registerMediaConversions(function (Media $media) {
                $this->addMediaConversion('thumb')
                    ->width(300)
                    ->height(300)
                    ->sharpen(10)
                 ->nonQueued();

                $this->addMediaConversion('card')
              ->width(600)
                  ->height(600)
           ->sharpen(10)
             ->nonQueued();

          $this->addMediaConversion('large')
                    ->width(1200)
           ->height(1200)
                  ->sharpen(10)
                    ->nonQueued();
         });
    }
}
