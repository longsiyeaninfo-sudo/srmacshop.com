<?php

namespace App\Models;

use App\Enums\TradeInStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class TradeIn extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'ticket_number',
        'device_type', 'model', 'storage', 'condition_grade', 'battery_health',
        'asking_price', 'offer_price', 'description',
        'customer_name', 'customer_phone', 'contact_method',
        'status', 'admin_notes',
    ];

    protected $casts = [
        'status' => TradeInStatus::class,
        'battery_health' => 'integer',
        'asking_price' => 'integer',
        'offer_price' => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function (TradeIn $tradeIn) {
            if (empty($tradeIn->ticket_number)) {
                $tradeIn->ticket_number = 'TI-' . strtoupper(Str::random(6));
            }
            if (empty($tradeIn->status)) {
                $tradeIn->status = TradeInStatus::New;
            }
        });
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photos');
    }
}
