<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\PaymentMethods;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CoursesController extends Controller
{
    /**
     * Display a listing of active courses.
     */
    public function index()
    {
        try {
            // Optional: cache for 10 minutes in production
            $courses = Cache::remember('frontend_courses_all', 600, function () {
                return Course::with([
                        'teacher' => fn($q) => $q->withDefault(['name' => 'N/A']),
                        'company' => fn($q) => $q->withDefault(['name' => 'N/A'])
                    ])
                    ->where('active_status', 'active')
                    ->orderBy('id')
                    ->get()
                    ->map([$this, 'enhanceCourse']);
            });

            return view('frontend.courses', compact('courses'));
        } catch (\Exception $e) {
            Log::error('CoursesController@index error: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'Failed to load courses.');
        }
    }

    /**
     * Display the specified course with payment methods.
     */
    public function show($slug)
    {
        try {
            $course = Course::with([
                    'teacher' => fn($q) => $q->withDefault(['name' => 'N/A']),
                    'company' => fn($q) => $q->withDefault(['name' => 'N/A'])
                ])
                ->where('active_status', 'active')
                ->where('slug', $slug)
                ->firstOrFail();

            $course = $this->enhanceCourse($course);

            $payment_methods = PaymentMethods::where('active', true)
                ->orderBy('method_name')
                ->get();

            return view('frontend.courses-show', compact('course', 'payment_methods'));
        } catch (\Exception $e) {
            Log::error('CoursesController@show error (slug: ' . $slug . '): ' . $e->getMessage());
            return redirect()->route('courses.index')
                ->with('error', 'Course not found or currently unavailable.');
        }
    }

    /**
     * Handle course enrollment.
     */
    public function enroll(Request $request, Course $course) // Auto-resolved by {course:slug}
    {
        // Ensure course is active and has seats
        if ($course->active_status !== 'active') {
            return back()->with('error', 'This course is no longer available.');
        }

        if (($course->available_seats ?? 0) <= 0) {
            return back()->with('error', 'Sorry, no seats left for this course.');
        }

        $validated = $request->validate([
            'full_name'      => 'required|string|max:255',
            'email'          => 'required|email|max:255',
            'phone'          => 'required|string|regex:/^\+?[0-9]{10,15}$/',
            'payment_method' => 'required|exists:payment_methods,id',
        ]);

        // Re-enhance course to get fresh discounted price
        $course = $this->enhanceCourse($course);

        // Generate strong random password
        $generatedPassword = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%'), 0, 10));

        // TODO: Save to enrollments table + send email
        // Enrollment::create([...]);

        $paymentMethod = PaymentMethods::findOrFail($validated['payment_method']);

        return redirect()->route('courses.show', $course->slug)
            ->with('success', 'You have been successfully enrolled!')
            ->with('password', $generatedPassword)
            ->with('payment_amount', $course->discounted_price_npr)
            ->with('payment_method', $paymentMethod->method_name . ' (' . $paymentMethod->account_holder . ')');
    }

    /**
     * Enhance course with calculated fields (DRY).
     */
    private function enhanceCourse(Course $course): Course
    {
        $course->duration_days       = $this->calculateDuration($course);
        $course->original_price_npr  = $course->price ?? 0;
        $course->discounted_price_npr = $course->price ?? 0;
        $course->available_seats     = ($course->total_seats ?? 0) - ($course->enrolled_seats ?? 0);
        $course->rating              = $course->rating ?? 'N/A';
        $course->syllabus            = $course->syllabus ?? 'No syllabus available.';
        $course->photo               = $course->photo ?? 'courses/default.jpg';

        $discount = $this->calculateDiscount($course);
        if ($discount > 0) {
            $course->discounted_price_npr = round($course->original_price_npr * (1 - $discount / 100), 2);
        }

        return $course;
    }

    /**
     * Calculate course duration in days.
     */
    private function calculateDuration(Course $course): int
    {
        try {
            $start = $course->start_date ? Carbon::parse($course->start_date) : now();
            $end   = $course->end_date   ? Carbon::parse($course->end_date)   : $start;
            return $start->diffInDays($end);
        } catch (\Exception $e) {
            Log::warning('Invalid dates for course ID: ' . $course->id);
            return 0;
        }
    }

    /**
     * Calculate active discount percentage.
     */
    private function calculateDiscount(Course $course): float
    {
        if (!$course->discount_valid_from || !$course->discount_valid_to || !$course->discount_percentage) {
            return 0;
        }

        try {
            $now  = Carbon::now()->setTimezone('Asia/Kathmandu');
            $from = Carbon::parse($course->discount_valid_from);
            $to   = Carbon::parse($course->discount_valid_to)->endOfDay();

            return $now->between($from, $to) ? (float) $course->discount_percentage : 0;
        } catch (\Exception $e) {
            Log::warning('Invalid discount dates for course ID: ' . $course->id);
            return 0;
        }
    }
}
