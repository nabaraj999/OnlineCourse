<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{


    protected $fillable = [
        'course_id',
        'payment_method_id',
        'full_name',
        'email',
        'phone',
        'reference_code',
        'screenshot_path',
        'screenshot_url',
        'amount_paid',
        'password',
        'plain_password',
        'status',
        'enrolled_at',
    ];

    protected $casts = [
        'enrolled_at' => 'datetime',
    ];
}
