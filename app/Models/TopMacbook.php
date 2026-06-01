<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TopMacbook extends Model
{
    protected $fillable = [
        'product_id',
        'label_en', 'label_km', 'label_zh',
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
            ->whereHas('product', fn ($q) => $q->where('is_active', true))
            ->orderBy('sort_order')
            ->orderBy('id');
    }
}
