<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class ProductSpec extends Model
{
    use HasTranslations;
    protected $fillable = ['product_id', 'key', 'value', 'sort_order'];

    public $translatable = ['value'];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function product(): BelongsTo
    {
      return $this->belongsTo(Product::class);
    }
}
