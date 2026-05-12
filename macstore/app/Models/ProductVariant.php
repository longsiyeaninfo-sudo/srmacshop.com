<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id', 'sku', 'ram', 'storage', 'color',
        'price_modifier', 'stock_quantity', 'is_active'
    ];

    protected $casts = [
        'price_modifier' => 'decimal:2',
        'stock_quantity' => 'integer',
      'is_active' => 'boolean',
  ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderItems(): HasMany
    {
     return $this->hasMany(OrderItem::class);
    }

    public function getFinalPriceAttribute(): float
    {
        return $this->product->base_price + $this->price_modifier;
    }
}
