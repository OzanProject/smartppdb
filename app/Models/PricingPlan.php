<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'price_display',
        'billing_cycle',
        'trial_days',
        'description',
        'features',
        'is_popular',
        'order_weight',
        'cta_text',
        'cta_link',
        'allowed_modules',
        'max_quota',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'trial_days' => 'integer',
        'is_popular' => 'boolean',
        'order_weight' => 'integer',
        'allowed_modules' => 'array',
        'max_quota' => 'integer',
    ];

    /**
     * Get features as an array.
     */
    public function getFeaturesListAttribute(): array
    {
        if (!$this->features) return [];
        
        return array_filter(array_map('trim', explode("\n", $this->features)));
    }

    public function schools(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(School::class);
    }
}
