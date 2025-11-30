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
        'start_date' => 'date:d M Y',   // optional: format on retrieve
            'end_date'   => 'date:d M Y',
            'price'      => 'decimal:2',
        'photo' => 'string', // Ensure photo is stored as a string (path)
        'syllabus' => 'array', // Cast syllabus to array for easier handling
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function certificates()
{
    return $this->hasMany(Certificate::class);
}
public function enrollments()
{
    return $this->hasMany(Enrollment::class);
}
// In app/Models/Course.php
public function resources()
{
    return $this->hasMany(CourseResource::class)
                ->orderBy('resource_date')
                ->orderBy('sort_order');
}

public function publishedResources()
{
    return $this->hasMany(CourseResource::class)
                ->where('is_published', true)
                ->orderBy('resource_date')
                ->orderBy('sort_order');
}
}
