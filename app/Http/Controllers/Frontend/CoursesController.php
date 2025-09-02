<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CoursesController extends Controller
{
    public function index()
    {
        try {
            // Bypass cache for debugging
            Cache::forget('frontend_courses_all');

            $courses = Course::with([
                'teacher' => fn($query) => $query->withDefault(),
                'company' => fn($query) => $query->withDefault()
            ])
                ->where('active_status', 'active')
                ->orderBy('id')
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

            // Log detailed course data at current time
            $currentTime = Carbon::now()->setTimezone('Asia/Kathmandu')->format('Y-m-d H:i:s T');
            Log::info('Courses fetched for courses page at ' . $currentTime, [
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

            return view('frontend.courses', compact('courses'));
        } catch (\Exception $e) {
            Log::error('Error in CoursesController@index: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'courses_count' => isset($courses) ? $courses->count() : 0,
                'time' => Carbon::now()->setTimezone('Asia/Kathmandu')->format('Y-m-d H:i:s T'),
            ]);
            return redirect()->back()->with('error', 'An error occurred while loading the courses page. Please try again later.');
        }
    }

    public function show($id)
    {
        try {
            $course = Course::with([
                'teacher' => fn($query) => $query->withDefault(),
                'company' => fn($query) => $query->withDefault()
            ])
                ->where('active_status', 'active')
                ->findOrFail($id);

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

            // Log course details
            $currentTime = Carbon::now()->setTimezone('Asia/Kathmandu')->format('Y-m-d H:i:s T');
            Log::info('Course details fetched at ' . $currentTime, [
                'course_id' => $course->id,
                'title' => $course->title,
                'price' => $course->price,
                'total_seats' => $course->total_seats,
                'enrolled_seats' => $course->enrolled_seats,
                'start_date' => $course->start_date,
                'teacher_id' => $course->teacher_id,
                'company_id' => $course->company_id,
            ]);

            return view('frontend.courses-show', compact('course'));
        } catch (\Exception $e) {
            Log::error('Error in CoursesController@show: ' . $e->getMessage(), [
                'course_id' => $id,
                'trace' => $e->getTraceAsString(),
                'time' => Carbon::now()->setTimezone('Asia/Kathmandu')->format('Y-m-d H:i:s T'),
            ]);
            return redirect()->route('courses.index')->with('error', 'Course not found or an error occurred.');
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
