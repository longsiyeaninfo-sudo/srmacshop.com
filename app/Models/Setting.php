<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    public static function get(string $key, mixed $default = null): mixed
    {
        return Cache::rememberForever('setting:'.$key, function () use ($key, $default) {
            return optional(static::where('key', $key)->first())->value ?? $default;
        });
    }

    public static function put(string $key, ?string $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget('setting:'.$key);
    }

    protected static function booted(): void
    {
        static::saved(fn (self $s) => Cache::forget('setting:'.$s->key));
        static::deleted(fn (self $s) => Cache::forget('setting:'.$s->key));
    }
}
