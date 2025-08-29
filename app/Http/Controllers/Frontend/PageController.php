<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class PageController extends Controller
{
    public function home()
    {
        try {
            // Cache courses for 1 hour to improve performance
            $courses = Cache::remember('frontend_courses', 3600, function () {
                return Course::with(['teacher', 'company'])
                    ->where('active_status', 'active') // Only fetch active courses
                    ->take(3)
                    ->get()
                    ->map(function ($course) {
                        // Initialize with original price
                        $course->duration_days = $this->calculateDuration($course);
                        $course->original_price_npr = $course->price;
                        $course->discounted_price_npr = $course->price; // Default to original price
                        $course->available_seats = $course->total_seats - $course->enrolled_seats;

                        // Calculate discount only if active (already ensured by where clause)
                        if ($course->active_status === 'active') {
                            $discountPercentage = $this->calculateDiscount($course);
                            $course->discounted_price_npr = $course->original_price_npr * (1 - $discountPercentage / 100);
                        }

                        return $course;
                    });
            });

            // Cache teachers for 1 hour
            $teachers = Cache::remember('frontend_teachers', 3600, fn () => Teacher::all());

            return view('frontend.home', compact('courses', 'teachers'));
        } catch (\Exception $e) {
            Log::error('Error in PageController@home: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while loading the page. Please try again later.');
        }
    }

    /**
     * Calculate the duration in days between start_date and end_date (or now if end_date is null).
     */
    private function calculateDuration($course)
    {
        $start = Carbon::parse($course->start_date);
        $end = $course->end_date ? Carbon::parse($course->end_date) : Carbon::now();
        return $start->diffInDays($end);
    }

    /**
     * Calculate the discount percentage if the discount period is valid.
     */
    private function calculateDiscount($course)
    {
        $discountPercentage = 0;
        if ($course->discount_valid_from && $course->discount_valid_to) {
            $now = Carbon::now();
            if ($now->between(Carbon::parse($course->discount_valid_from), Carbon::parse($course->discount_valid_to))) {
                $discountPercentage = $course->discount_percentage ?? 0;
            }
        }
        return $discountPercentage;
    }
}
