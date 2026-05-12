<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $fillable = [
        'order_number', 'user_id', 'email', 'phone',
        'status', 'payment_status', 'payment_method',
        'subtotal', 'discount_total', 'shipping_total', 'tax_total', 'grand_total',
        'currency', 'shipping_address', 'billing_address',
        'coupon_code', 'notes',
        'paid_at', 'shipped_at', 'delivered_at', 'cancelled_at'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount_total' => 'decimal:2',
    'shipping_total' => 'decimal:2',
        'tax_total' => 'decimal:2',
      'grand_total' => 'decimal:2',
        'shipping_address' => 'array',
    'billing_address' => 'array',
        'paid_at' => 'datetime',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($order) {
       if (!$order->order_number) {
             $order->order_number = 'MS-' . strtoupper(uniqid());
            }
        });
    }
}
