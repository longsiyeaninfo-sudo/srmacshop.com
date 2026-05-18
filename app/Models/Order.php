<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'order_number', 'customer_name', 'customer_phone', 'customer_address',
        'payment_method', 'subtotal', 'discount', 'tax', 'total', 'coupon_code',
        'status', 'notes', 'stripe_session_id',
    ];

    protected $casts = [
        'status' => OrderStatus::class,
        'subtotal' => 'integer',
        'discount' => 'integer',
        'tax' => 'integer',
        'total' => 'integer',
    ];

    protected static function booted(): void
    {
        static::created(function (self $order) {
            if (empty($order->order_number) || str_starts_with($order->order_number, 'TMP')) {
                $order->order_number = 'SR-' . str_pad((string) (1000 + $order->id), 4, '0', STR_PAD_LEFT);
                $order->saveQuietly();
            }
        });
    }

  public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
