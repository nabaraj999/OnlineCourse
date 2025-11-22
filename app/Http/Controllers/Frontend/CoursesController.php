<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\PaymentMethods;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CoursesController extends Controller
{
    public function index()
    {
        try {
            $courses = Cache::remember('frontend_courses_active', 600, function () {
                return Course::with([
                        'teacher:id,name',
                        'company:id,name'
                    ])
                    ->where('active_status', 'active')
                    ->orderByDesc('id')
                    ->get()
                    ->map([$this, 'enhanceCourse']);
            });

            return view('frontend.courses', compact('courses'));
        } catch (\Exception $e) {
            Log::error('CoursesController@index error: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'Failed to load courses.');
        }
    }

    public function show($slug)
    {
        try {
            $course = Course::with([
                    'teacher:id,name',
                    'company:id,name'
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
            Log::error("Course show error [slug: $slug]: " . $e->getMessage());
            return redirect()->route('courses.index')
                ->with('error', 'Course not found or currently unavailable.');
        }
    }

    public function enroll(Request $request, Course $course)
    {
        if ($course->active_status !== 'active') {
            return back()->with('error', 'This course is no longer active.');
        }

        $availableSeats = $course->total_seats - $course->enrolled_seats;
        if ($availableSeats <= 0) {
            return back()->with('error', 'Sorry, this course is fully booked.');
        }

        $request->validate([
            'full_name'      => 'required|string|max:255',
            'email'          => 'required|email|max:255',
            'phone'          => 'required|string|regex:/^\+?[0-9]{10,15}$/',
            'payment_method' => 'required|exists:payment_methods,id',
        ]);

        // Refresh enhanced data
        $course = $this->enhanceCourse($course);

        $password = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&'), 0, 12));

        $paymentMethod = PaymentMethods::findOrFail($request->payment_method);

        // TODO: Save enrollment here later

        return back()->with([
            'success'          => 'Enrollment successful! Please complete your payment.',
            'generated_password' => $password,
            'payment_amount'   => number_format($course->discounted_price_npr, 2),
            'payment_method'   => $paymentMethod->method_name .
                                 ($paymentMethod->account_holder ? ' - ' . $paymentMethod->account_holder : '')
        ]);
    }

    /**
     * Add computed attributes to course
     */
    public function enhanceCourse(Course $course): Course
    {
        $now = Carbon::now('Asia/Kathmandu');

        // Basic computed fields
        $course->available_seats = $course->total_seats - $course->enrolled_seats;
        $course->duration_days   = $this->calculateDuration($course);
        $course->original_price_npr = $course->price;
        $course->photo_path      = $course->photo ? Storage::url($course->photo) : asset('images/courses/default.jpg');

        // Discount logic
        $discountPercentage = 0;
        if (
            $course->discount_percentage > 0 &&
            $course->discount_valid_from &&
            $course->discount_valid_to
        ) {
            $from = Carbon::parse($course->discount_valid_from);
            $to   = Carbon::parse($course->discount_valid_to)->endOfDay();

            if ($now->between($from, $to)) {
                $discountPercentage = (float) $course->discount_percentage;
            }
        }

        $course->active_discount = $discountPercentage > 0;
        $course->discount_percentage_active = $discountPercentage;

        if ($discountPercentage > 0) {
            $course->discounted_price_npr = round($course->price * (1 - $discountPercentage / 100), 2);
        } else {
            $course->discounted_price_npr = $course->price;
        }

        return $course;
    }

    private function calculateDuration(Course $course): int
    {
        if (!$course->start_date) return 0;

        $start = Carbon::parse($course->start_date);
        $end   = $course->end_date ? Carbon::parse($course->end_date) : $start;

        return $start->diffInDays($end) + 1; // inclusive
    }
}
