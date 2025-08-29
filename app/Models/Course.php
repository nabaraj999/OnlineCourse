<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'title', 'teacher_id', 'company_id', 'discount_percentage', 'discount_valid_from', 'discount_valid_to',
        'start_date', 'end_date', 'price', 'total_seats', 'enrolled_seats', 'daily_time', 'syllabus', 'photo',
        'active_status', 'rating', 'slug'
    ];

     protected $casts = [
        'photo' => 'string', // Ensure photo is stored as a string (path)
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
