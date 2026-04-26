<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Traits\BelongsToSchool;

class LandingContent extends Model
{
    use HasFactory, BelongsToSchool;

    protected $fillable = [
        'school_id',
        'type',
        'title',
        'subtitle',
        'content',
        'image',
        'order_weight',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order_weight' => 'integer',
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
}
