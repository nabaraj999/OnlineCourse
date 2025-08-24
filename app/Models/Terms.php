<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Terms extends Model
{
    protected $fillable = [
        'title', 'active', 'description'
    ];

    protected $casts = [
        'active' => 'boolean',
        'title' => 'string',
        'description' => 'string',
    ];
}
