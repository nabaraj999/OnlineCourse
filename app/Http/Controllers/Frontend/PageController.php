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
            // Bypass cache for debugging
            Cache::forget('frontend_courses');

            $courses = Course::with([
                'teacher' => fn($query) => $query->withDefault(),
                'company' => fn($query) => $query->withDefault()
            ])
                ->where('active_status', 'active')
                ->orderBy('id') // Ensure consistent ordering
                ->take(3)
                ->get()
                ->map(function ($course) {
                    $course->duration_days = $this->calculateDuration($course);
                    $course->original_price_npr = $course->price ?? 0;
                    $course->discounted_price_npr = $course->price ?? 0;
                    $course->available_seats = ($course->total_seats ?? 0) - ($course->enrolled_seats ?? 0);
                    $course->rating = $course->rating ?? 'N/A';
                    $course->syllabus = $course->syllabus ?? 'No description available';
                    $course->photo = $course->photo ?? 'default.jpg';

                    if ($course->active_status === 'active') {
                        $discountPercentage = $this->calculateDiscount($course);
                        $course->discounted_price_npr = $course->original_price_npr * (1 - $discountPercentage / 100);
                    }

                    return $course;
                });

            // Log detailed course data at current time (05:20 PM +0545, August 29, 2025)
            $currentTime = Carbon::now()->setTimezone('Asia/Kathmandu')->format('Y-m-d H:i:s T');
            Log::info('Courses fetched for home page at ' . $currentTime, [
                'count' => $courses->count(),
                'course_ids' => $courses->pluck('id')->toArray(),
                'titles' => $courses->pluck('title')->toArray(),
                'details' => $courses->map(function ($course) {
                    return [
                        'id' => $course->id,
                        'price' => $course->price,
                        'total_seats' => $course->total_seats,
                        'enrolled_seats' => $course->enrolled_seats,
                        'start_date' => $course->start_date,
                        'teacher_id' => $course->teacher_id,
                        'company_id' => $course->company_id,
                    ];
                })->all(),
            ]);

            $teachers = Cache::remember('frontend_teachers', 3600, fn () => Teacher::all());

            return view('frontend.home', compact('courses', 'teachers'));
        } catch (\Exception $e) {
            Log::error('Error in PageController@home: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'courses_count' => isset($courses) ? $courses->count() : 0,
                'time' => Carbon::now()->setTimezone('Asia/Kathmandu')->format('Y-m-d H:i:s T'),
            ]);
            return redirect()->back()->with('error', 'An error occurred while loading the page. Please try again later.');
        }
    }

    private function calculateDuration($course)
    {
        try {
            $start = $course->start_date ? Carbon::parse($course->start_date) : Carbon::now();
            $end = $course->end_date ? Carbon::parse($course->end_date) : Carbon::now();
            return $start->diffInDays($end);
        } catch (\Exception $e) {
            Log::warning('Invalid date for course ID ' . ($course->id ?? 'unknown') . ': ' . $e->getMessage());
            return 0;
        }
    }

    private function calculateDiscount($course)
    {
        $discountPercentage = 0;
        if ($course->discount_valid_from && $course->discount_valid_to) {
            try {
                $now = Carbon::now()->setTimezone('Asia/Kathmandu');
                $from = Carbon::parse($course->discount_valid_from);
                $to = Carbon::parse($course->discount_valid_to);
                if ($now->between($from, $to)) {
                    $discountPercentage = $course->discount_percentage ?? 0;
                }
            } catch (\Exception $e) {
                Log::warning('Invalid discount dates for course ID ' . ($course->id ?? 'unknown') . ': ' . $e->getMessage());
            }
        }
        return $discountPercentage;
    }
}
