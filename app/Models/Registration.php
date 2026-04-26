<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Traits\BelongsToSchool;

class Registration extends Model
{
    use HasFactory, BelongsToSchool;

    protected $fillable = [
        'registration_number',
        'user_id',
        'school_id',
        'admission_batch_id',
        'status',
        'personal_data',
        'parent_data',
        'previous_school_data',
        'additional_data',
        'note',
    ];

    protected function casts(): array
    {
        return [
            'personal_data' => 'array',
            'parent_data' => 'array',
            'previous_school_data' => 'array',
            'additional_data' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function admissionBatch(): BelongsTo
    {
        return $this->belongsTo(AdmissionBatch::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    /**
     * Get applicant name from user or personal_data.
     */
    public function getApplicantNameAttribute(): string
    {
        if ($this->user_id && $this->user) {
            return $this->user->name;
        }

        return $this->personal_data['full_name'] 
            ?? $this->personal_data['Nama Lengkap'] 
            ?? 'Pendaftar Baru';
    }

    /**
     * Get applicant email from user or data.
     */
    public function getApplicantEmailAttribute(): string
    {
        if ($this->user_id && $this->user) {
            return $this->user->email;
        }

        return $this->additional_data['Email'] 
            ?? $this->personal_data['Email'] 
            ?? '-';
    }

    /**
     * Get NISN from form data.
     */
    public function getNisnAttribute(): ?string
    {
        $data = $this->all_form_data;
        
        // Search specifically for common keys first
        if (isset($data['nisn'])) return $data['nisn'];
        if (isset($data['NISN'])) return $data['NISN'];
        if (isset($data['Nisn'])) return $data['Nisn'];

        // Fallback: search for any key containing "NISN" (case-insensitive)
        foreach ($data as $key => $value) {
            if (stripos($key, 'NISN') !== false) {
                return $value;
            }
        }

        return null;
    }

    /**
     * Get all form data merged.
     */
    public function getAllFormDataAttribute(): array
    {
        return array_merge(
            $this->personal_data ?? [],
            $this->parent_data ?? [],
            $this->previous_school_data ?? [],
            $this->additional_data ?? []
        );
    }
}
