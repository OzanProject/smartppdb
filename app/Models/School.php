<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'education_level_code',
        'education_level_name',
        'is_custom_level',
        'npsn',
        'email',
        'phone',
        'address',
        'logo',
        'is_registration_open',
        'hero_title',
        'hero_description',
        'hero_image',
        'stats_acc_label',
        'stats_acc_value',
        'stats_count_label',
        'stats_count_value',
        'stats_grad_label',
        'stats_grad_value',
        'is_active',
        'pricing_plan_id',
        'trial_ends_at',
        'timezone',
    ];

    protected function casts(): array
    {
        return [
            'is_custom_level' => 'boolean',
            'is_registration_open' => 'boolean',
            'is_active' => 'boolean',
            'pricing_plan_id' => 'integer',
            'trial_ends_at' => 'datetime',
        ];
    }

    public function hasActiveTrial(): bool
    {
        return $this->trial_ends_at && $this->trial_ends_at->isFuture();
    }

    public function hasModuleAccess(string $module): bool
    {
        if ($this->hasActiveTrial()) {
            return true;
        }

        if (!$this->pricingPlan || !$this->pricingPlan->allowed_modules) {
            return false;
        }

        return in_array($module, $this->pricingPlan->allowed_modules);
    }

    public function hasAvailableQuota(): bool
    {
        if ($this->hasActiveTrial()) {
            return true;
        }

        $plan = $this->pricingPlan;
        if (!$plan || $plan->max_quota == -1) {
            return true;
        }

        return $this->registrations()->count() < $plan->max_quota;
    }

    public function getQuotaStatus(): array
    {
        $plan = $this->pricingPlan;
        if (!$plan || $plan->max_quota == -1 || $this->hasActiveTrial()) {
            return ['is_limited' => false];
        }

        $currentCount = $this->registrations()->count();
        $remaining = max(0, $plan->max_quota - $currentCount);

        return [
            'is_limited' => true,
            'max' => $plan->max_quota,
            'current' => $currentCount,
            'remaining' => $remaining
        ];
    }

    public function pricingPlan(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(PricingPlan::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function academicYears(): HasMany
    {
        return $this->hasMany(AcademicYear::class);
    }

    public function formSections(): HasMany
    {
        return $this->hasMany(FormSection::class)->orderBy('order_weight');
    }

    public function documentRequirements(): HasMany
    {
        return $this->hasMany(DocumentRequirement::class)->orderBy('order_weight');
    }

    public function admissionBatches(): HasMany
    {
        return $this->hasMany(AdmissionBatch::class);
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }
}