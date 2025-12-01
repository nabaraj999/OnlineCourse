<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{
    BelongsTo as RelationsBelongsTo,
    Relations\BelongsTo,
    SoftDeletes
};

class CourseMaterial extends Model
{
    // If you kept the table name as 'course_materials'
    protected $table = 'course_materials';

    // If you want to allow mass assignment for all these fields
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

    // Casts for proper typing
    protected $casts = [
        'resource_date' => 'date',
        'is_published'  => 'boolean',
        'sort_order'    => 'integer',
    ];

    // Optional: if you ever add soft deletes
    // use SoftDeletes;

    /**
     * Relationships
     */
    public function course(): RelationsBelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function uploadedBy(): RelationsBelongsTo
    {
        return $this->belongsTo(Teacher::class, 'uploaded_by')->withDefault([
            'name' => 'System'
        ]);
    }

    /**
     * Accessors & Helpers
     */
    public function getContentUrlAttribute(): ?string
    {
        return $this->file_path
            ? asset('storage/' . $this->file_path)
            : $this->external_url;
    }

    public function hasFile(): bool
    {
        return !is_null($this->file_path);
    }

    public function hasExternalUrl(): bool
    {
        return !is_null($this->external_url);
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'ppt'        => 'PowerPoint',
            'pdf'        => 'PDF',
            'video'      => 'Video',
            'image'      => 'Image',
            'assignment' => 'Assignment',
            'note'       => 'Note',
            'link'       => 'External Link',
            default      => 'Other',
        };
    }
}
