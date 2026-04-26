<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingSetting extends Model
{
    use HasFactory;

    protected $fillable = ['group', 'key', 'value', 'type'];

    /**
     * Get a setting value by key.
     */
    public static function getValue(string $key, $default = null): ?string
    {
        return self::where('key', $key)->value('value') ?? $default;
    }

    /**
     * Get all settings as a key-value array.
     */
    public static function getSettings(): array
    {
        return self::pluck('value', 'key')->toArray();
    }
}
