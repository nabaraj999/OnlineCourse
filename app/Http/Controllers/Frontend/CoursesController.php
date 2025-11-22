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
use Illuminate\Validation\ValidationException;

class CoursesController extends Controller
{
    public function index()
    {
        try {
            $courses = Cache::remember('frontend_courses_active', 600, function () {
                return Course::with(['teacher:id,name', 'company:id,name'])
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
            $course = Course::with(['teacher:id,name', 'company:id,name'])
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

    // FINAL & BEST VERSION OF ENROLL STORE
    public function enrollStore(Request $request)
    {
        $request->validate([
            'course_id'         => 'required|exists:courses,id',
            'full_name'         => 'required|string|max:255',
            'email'             => 'required|email|max:255',
            'phone'             => 'required|string|regex:/^\+?[0-9]{10,15}$/',
            'reference_code'    => 'required|string|max:50',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'screenshot'        => 'required|image|mimes:jpg,jpeg,png|max:5048',
        ]);

        return DB::transaction(function () use ($request) {
            // Lock the course row to prevent race condition
            $course = Course::where('id', $request->course_id)
                ->where('active_status', 'active')
                ->lockForUpdate()
                ->firstOrFail();

            // Re-apply discount logic (important after lock)
            $course = $this->enhanceCourse($course);

            // Check available seats
            $availableSeats = $course->total_seats - $course->enrolled_seats;

            if ($availableSeats <= 0) {
                throw ValidationException::withMessages([
                    'course_id' => 'Sorry, this course is now fully booked!'
                ]);
            }

            // Optional: Prevent duplicate enrollment (recommended)
            $existing = Enrollment::where('course_id', $course->id)
                ->whereIn('email', [$request->email])
                ->orWhere('phone', $request->phone)
                ->first();

            if ($existing) {
                throw ValidationException::withMessages([
                    'email' => 'You have already enrolled in this course.'
                ]);
            }

            // Check reference code uniqueness
            if (Enrollment::where('reference_code', $request->reference_code)->exists()) {
                throw ValidationException::withMessages([
                    'reference_code' => 'This transaction reference has already been used.'
                ]);
            }

            // Generate strong random password
            $plainPassword = strtoupper(Str::random(6)) . rand(10, 99);

            // Store screenshot
            $screenshot = $request->file('screenshot');
            $filename = time() . '_' . $request->reference_code . '.' . $screenshot->getClientOriginalExtension();
            $path = $screenshot->storeAs('enrollments/screenshots', $filename, 'public');

            // Create enrollment
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

            // Atomically increment enrolled seats
            $course->increment('enrolled_seats');

            Log::info('New enrollment created', [
                'enrollment_id' => $enrollment->id,
                'course'        => $course->title,
                'student'       => $request->full_name,
                'email'         => $request->email,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Enrollment submitted successfully! Your account has been created.',
                'plain_password' => $plainPassword,
                'enrollment_id' => $enrollment->id
            ]);
        });
    }

    public function enhanceCourse(Course $course): Course
    {
        $now = Carbon::now('Asia/Kathmandu');

        $course->available_seats = $course->total_seats - $course->enrolled_seats;
        $course->duration_days   = $this->calculateDuration($course);
        $course->original_price_npr = $course->price;
        $course->photo_path = $course->photo
            ? Storage::url($course->photo)
            : asset('images/courses/default.jpg');

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
