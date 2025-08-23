<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'title', 'teacher_id', 'company_id', 'discount_id', 'start_date', 'end_date', 'price',
        'total_seats', 'enrolled_seats', 'daily_time', 'syllabus', 'photo',
        'active_status', 'rating', 'slug'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'daily_time' => 'datetime:time',
        'price' => 'string',
        'rating' => 'string',
        'total_seats' => 'integer',
        'enrolled_seats' => 'integer',
        'active_status' => 'boolean',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    public function getFinalPriceAttribute()
    {
        $discount = $this->discount;
        $originalPrice = $this->price ?? 0.00;

        if ($discount && $discount->is_active && $discount->start_date <= now() &&
            ($discount->end_date >= now() || $discount->end_date === null)) {
            if ($discount->price !== null) {
                return $discount->price; // Use overridden price if provided
            }
            $discountPercent = $discount->discount_percent ?? 0.00;
            return $originalPrice - ($originalPrice * ($discountPercent / 100));
        }

        return $originalPrice; // No valid discount applied
    }
}
