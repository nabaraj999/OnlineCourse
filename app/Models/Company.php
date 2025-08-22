<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'background_image',
        'logo',
        'favicon',
        'email',
        'facebook_url',
        'instagram_url',
        'youtube_url',
        'whatsapp_number',
        'viber_number',
        'registration_number',
        'pan_number',
        'description',
        'website_url',
        'phone_number',
        'address',
        'founded_date',
    ];

    // Add any relationships here if needed, e.g., if companies have courses:
    // public function courses()
    // {
    //     return $this->hasMany(Course::class);
    // }
}
