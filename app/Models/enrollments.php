<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id', 'name', 'email', 'phone', 'comments', 'payment_method', 'transaction_id', 'status'
    ];
}
