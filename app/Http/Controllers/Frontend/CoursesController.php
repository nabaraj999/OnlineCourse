<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\PaymentMethods;
use App\Models\Enrollment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
                ->orderBy('sort_order')
                ->get();

            return view('frontend.courses-show', compact('course', 'payment_methods'));
        } catch (\Exception $e) {
            Log::error("Course show error [slug: $slug]: " . $e->getMessage());
            return redirect()->route('courses.index')
                ->with('error', 'Course not found or currently unavailable.');
        }
    }

    // AJAX Enrollment via Modal (New Method)
    public function enrollStore(Request $request)
    {
        $request->validate([
            'course_id'        => 'required|exists:courses,id',
            'full_name'        => 'required|string|max:255',
            'email'            => 'required|email|max:255',
            'phone'            => 'required|string|regex:/^\+?[0-9]{10,15}$/',
            'reference_code'   => 'required|string|max:50|unique:enrollments,reference_code',
            'payment_method_id'=> 'required|exists:payment_methods,id',
            'screenshot'       => 'required|image|mimes:jpg,jpeg,png|max:5048',
        ]);

        return DB::transaction(function () use ($request) {
            $course = Course::findOrFail($request->course_id);
            $course = $this->enhanceCourse($course); // Apply discount logic

            // Double-check seat availability with row lock
            $availableSeats = $course->total_seats - $course->enrolled_seats;
            if ($availableSeats <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sorry, this course is now fully booked!'
                ], 422);
            }

            // Generate secure password
            $plainPassword = strtoupper(Str::random(8)) . rand(10, 99);
            $screenshot = $request->file('screenshot');
            $path = $screenshot->store('enrollments/screenshots', 'public');

            $enrollment = Enrollment::create([
                'course_id'         => $course->id,
                'payment_method_id' => $request->payment_method_id,
                'full_name'         => $request->full_name,
                'email'             => $request->email,
                'phone'             => $request->phone,
                'reference_code'    => $request->reference_code,
                'screenshot_path'   => $path,
                'screenshot_url'    => Storage::url($path),
                'amount_paid'       => $course->discounted_price_npr,
                'password'          => Hash::make($plainPassword),
                'plain_password'    => $plainPassword,
                'status'            => 'pending',
                'enrolled_at'       => now(),
            ]);

            // Decrement seats safely
            $course->increment('enrolled_seats');
            // Or if you have available_seats column:
            // $course->decrement('available_seats');

            Log::info("New enrollment created", [
                'enrollment_id' => $enrollment->id,
                'course' => $course->title,
                'student' => $request->full_name
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Enrollment successful! Your account is created.',
                'plain_password' => $plainPassword
            ]);
        });
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
        $course->photo_path = $course->photo
            ? Storage::url($course->photo)
            : asset('images/courses/default.jpg');

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
        $course->discounted_price_npr = $discountPercentage > 0
            ? round($course->price * (1 - $discountPercentage / 100), 0)
            : $course->price;

        return $course;
    }

    private function calculateDuration(Course $course): int
    {
        if (!$course->start_date) return 0;

        $start = Carbon::parse($course->start_date);
        $end   = $course->end_date ? Carbon::parse($course->end_date) : $start;

        return $start->diffInDays($end) + 1;
    }
}
