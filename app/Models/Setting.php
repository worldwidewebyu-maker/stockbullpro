<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    public const DEFAULT_WHATSAPP_NUMBER = '+13322830661';

    public const DEFAULT_TELEGRAM_USERNAME = 'finxstockbullcomsupport';

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

    public static function whatsappUrl(): string
    {
        $legacyLink = static::get('whatsapp_link');

        if ($legacyLink) {
            return $legacyLink;
        }

        $number = static::get('whatsapp_number') ?: static::DEFAULT_WHATSAPP_NUMBER;

        return whatsapp_url($number) ?? whatsapp_url(static::DEFAULT_WHATSAPP_NUMBER);
    }

    public static function telegramUrl(): string
    {
        $username = static::get('telegram_username') ?: static::DEFAULT_TELEGRAM_USERNAME;

        return telegram_url($username) ?? telegram_url(static::DEFAULT_TELEGRAM_USERNAME);
    }

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('settings.all'));
        static::deleted(fn () => Cache::forget('settings.all'));
    }
}
