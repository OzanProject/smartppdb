<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentSetting extends Model
{
    protected $fillable = ['key', 'value'];

    /**
     * Get all settings as key-value array.
     */
    public static function getSettings(): array
    {
        return self::pluck('value', 'key')->toArray();
    }

    /**
     * Get a specific setting value.
     */
    public static function getValue(string $key, $default = null): ?string
    {
        return self::where('key', $key)->value('value') ?? $default;
    }

    /**
     * Set a specific setting value.
     */
    public static function setValue(string $key, ?string $value): void
    {
        self::updateOrCreate(['key' => $key], ['value' => $value]);
    }
}
