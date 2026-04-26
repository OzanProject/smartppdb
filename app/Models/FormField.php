<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Traits\BelongsToSchool;

class FormField extends Model
{
    use HasFactory, BelongsToSchool;

    protected $fillable = [
        'form_section_id',
        'label',
        'help_text',
        'name',
        'type',
        'options',
        'is_required',
        'order_weight',
        'is_active',
        'is_featured',
    ];

    protected $casts = [
        'options' => 'array',
        'is_required' => 'boolean',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(FormSection::class, 'form_section_id');
    }
}
