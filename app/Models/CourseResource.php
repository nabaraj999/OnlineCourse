<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseResource extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'uploaded_by',
        'type',
        'title',
        'description',
        'file_path',
        'external_url',
        'resource_date',
        'sort_order',
        'is_published',
    ];

    protected $casts = [
        'resource_date' => 'date',
        'is_published'  => 'boolean',
    ];

    // Relationships
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'uploaded_by');
    }

    // Auto get URL (file or external)
    public function getUrlAttribute(): ?string
    {
        return $this->external_url ?:
               ($this->file_path ? asset('storage/' . $this->file_path) : null);
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
