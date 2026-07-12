<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    public $timestamps = true;

    public static function get(string $key, mixed $default = null): mixed
    {
        $all = Cache::rememberForever('settings.all', function () {
            return static::query()->pluck('value', 'key')->all();
        });

        return $all[$key] ?? $default;
    }

    public static function set(string $key, mixed $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget('settings.all');
    }

    public static function isEmailVerificationEnabled(): bool
    {
        return filter_var(static::get('email_verification_enabled', '1'), FILTER_VALIDATE_BOOLEAN);
    }

    public static function whatsappUrl(): ?string
    {
        $legacyLink = static::get('whatsapp_link');

        if ($legacyLink) {
            return $legacyLink;
        }

        return whatsapp_url(static::get('whatsapp_number'));
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('settings.all'));
        static::deleted(fn () => Cache::forget('settings.all'));
    }
}
