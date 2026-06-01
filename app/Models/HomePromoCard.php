<?php

namespace App\Models;

use App\Models\Concerns\WatermarksImagePath;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class HomePromoCard extends Model
{
    use WatermarksImagePath;

    protected $fillable = [
        'platform',
        'image_path',
        'headline_en', 'headline_km', 'headline_zh',
        'subtext_en',  'subtext_km',  'subtext_zh',
        'link_url',
        'cta_label_en', 'cta_label_km', 'cta_label_zh',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'sort_order' => 'integer',
    ];

    public function scopeActive(Builder $q): Builder
    {
        return $q->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    public function imageUrl(): ?string
    {
        return $this->image_path
            ? Storage::disk('public')->url($this->image_path)
            : null;
    }
}
