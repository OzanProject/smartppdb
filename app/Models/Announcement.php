<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\BelongsToSchool;

class Announcement extends Model
{
    use HasFactory, BelongsToSchool;

    protected $fillable = [
        'school_id',
        'admission_batch_id',
        'title',
        'content_success',
        'content_failure',
        'announcement_date',
        'is_published',
    ];

    protected function casts(): array
    {
        return [
            'announcement_date' => 'date',
            'is_published' => 'boolean',
        ];
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function admissionBatch(): BelongsTo
    {
        return $this->belongsTo(AdmissionBatch::class);
    }
}
