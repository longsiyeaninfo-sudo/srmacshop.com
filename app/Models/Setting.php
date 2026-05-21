<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];
    protected $casts = ['value' => 'array'];

    public static function get(string $key, mixed $default = null): mixed
    {
        $all = Cache::rememberForever('settings.all', fn () => static::all()->pluck('value', 'key')->all());
        return $all[$key] ?? $default;
    }

    public static function set(string $key, mixed $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget('settings.all');
    }

    /** @param array<string,mixed> $kv */
    public static function setMany(array $kv): void
    {
        foreach ($kv as $k => $v) {
            static::updateOrCreate(['key' => $k], ['value' => $v]);
        }
        Cache::forget('settings.all');
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('settings.all'));
        static::deleted(fn () => Cache::forget('settings.all'));
    }
}
