<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code', 'type', 'value', 'min_subtotal', 'max_uses', 'used_count',
        'expires_at', 'is_active',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
        'value' => 'integer',
        'min_subtotal' => 'integer',
        'max_uses' => 'integer',
      'used_count' => 'integer',
    ];

    public function isValid(int $subtotalCents): bool
    {
        if (! $this->is_active) {
        return false;
    }
        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }
        if ($this->max_uses > 0 && $this->used_count >= $this->max_uses) {
          return false;
        }
      if ($subtotalCents < $this->min_subtotal) {
          return false;
       }
        return true;
    }

    /** Returns discount in cents. */
    public function apply(int $subtotalCents): int
    {
        if (! $this->isValid($subtotalCents)) {
            return 0;
        }

        return $this->type === 'percent'
          ? (int) floor($subtotalCents * $this->value / 100)
            : min($this->value, $subtotalCents);
  }
}
