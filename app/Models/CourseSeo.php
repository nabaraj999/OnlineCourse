<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseSeo extends Model
{
    protected $fillable = [
        'course_id',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_title',
        'og_description',
        'og_image',
        'og_type',
        'twitter_title',
        'twitter_description',
        'twitter_image',
        'twitter_card',
        'canonical_url',
        'noindex',
        'nofollow',
        'structured_data',
        'seo_h1',
        'faq_schema',
        'breadcrumb_override',
    ];

    protected $casts = [
        'structured_data' => 'array',
        'faq_schema'      => 'array',
        'breadcrumb_override' => 'array',
        'noindex'    => 'boolean',
        'nofollow'   => 'boolean',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
