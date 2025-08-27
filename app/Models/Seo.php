<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
   protected $fillable = [
        'entity_type',
        'title',
        'description',
        'keywords',
        'slug',
        'canonical_url',
        'og_title',
        'og_description',
        'og_image',
        'twitter_card',
        'twitter_title',
        'twitter_description',
        'twitter_image',
        'noindex',
        'nofollow',
        'robots_txt_directives',
        'sitemap_priority',
        'last_modified',
        'schema_markup',
        'alt_text',
        'hreflang',
    ];

    protected $casts = [
        'noindex' => 'boolean',
        'nofollow' => 'boolean',
        'sitemap_priority' => 'float',
        'last_modified' => 'datetime',
    ];
}
