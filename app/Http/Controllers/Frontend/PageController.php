<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Teacher;
use Carbon\Carbon;

class PageController extends Controller
{
    public function home()
    {
        $courses = Course::with(['teacher', 'discount', 'company'])
            ->where('active_status', 'active')
            ->take(3)
            ->get()
            ->map(function ($course) {
                // Calculate duration in days
                $start = Carbon::parse($course->start_date);
                $end = $course->end_date ? Carbon::parse($course->end_date) : Carbon::now();
                $durationDays = $start->diffInDays($end);

                // Apply discount if valid
                $discount = $course->discount;
                $discountPercentage = 0;
                if ($discount && $discount->valid_from && $discount->valid_to) {
                    $now = Carbon::now();
                    if ($now->between($discount->valid_from, $discount->valid_to)) {
                        $discountPercentage = $discount->percentage ?? 0;
                    }
                }

                // Calculate discounted price in NPR (price is already in NPR)
                $originalPriceNPR = $course->price;
                $discountedPriceNPR = $originalPriceNPR * (1 - $discountPercentage / 100);
                $total_price = $originalPriceNPR - $discountedPriceNPR;

                $course->duration_days = $durationDays;
                $course->original_price_npr = $originalPriceNPR;
                $course->discounted_price_npr = $discountedPriceNPR;
                $course->available_seats = $course->total_seats - $course->enrolled_seats;

                return $course;
            });

        $teachers = Teacher::all();

        return view('frontend.home', compact('courses', 'teachers'));
    }
}
