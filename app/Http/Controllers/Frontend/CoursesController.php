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
use Illuminate\Support\Str;

class CoursesController extends Controller
{
    public function index()
    {
        try {
            $courses = Cache::remember('frontend_courses_all', 600, function () {
                return Course::with([
                    'teacher' => fn ($q) => $q->withDefault(['name' => 'N/A']),
                    'company' => fn ($q) => $q->withDefault(['name' => 'N/A'])
                ])
                    ->where('active_status', 'active')
                    ->orderBy('created_at', 'desc')
                    ->get()
                    ->map(fn ($course) => $this->enhanceCourse($course));
            });

            return view('frontend.courses', compact('courses'));
        } catch (\Exception $e) {
            Log::error('CoursesController@index: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'Failed to load courses.');
        }
    }

    public function show($slug)
    {
        try {
            $course = Course::with([
                'teacher' => fn ($q) => $q->withDefault(['name' => 'N/A']),
                'company' => fn ($q) => $q->withDefault(['name' => 'N/A'])
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
            Log::error("Course show error [{$slug}]: " . $e->getMessage());
            return redirect()->route('courses.index')
                ->with('error', 'Course not found or unavailable.');
        }
    }

    public function enroll(Request $request, Course $course)
    {
        if ($course->active_status !== 'active') {
            return back()->with('error', 'This course is no longer available.');
        }

        $availableSeats = ($course->total_seats ?? 0) - ($course->enrolled_seats ?? 0);
        if ($availableSeats <= 0) {
            return back()->with('error', 'No seats left!');
        }

        $validated = $request->validate([
            'full_name'          => 'required|string|max:255',
            'email'              => 'required|email|max:255',
            'phone'              => 'required|regex:/^(\+977)?[0-9]{10}$/',
            'payment_method'     => 'required|exists:payment_methods,id',
            'reference_code'     => 'required|string|max:100|unique:enrollments,reference_code',
            'payment_screenshot' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ], [
            'phone.regex'           => 'Valid Nepali number required (98XXXXXXXX)',
            'reference_code.unique' => 'This Transaction ID is already used.',
        ]);

        try {
            $course        = $this->enhanceCourse($course->fresh());
            $paymentMethod = PaymentMethods::findOrFail($validated['payment_method']);
            $now           = Carbon::now('Asia/Kathmandu');

            $path = $request->file('payment_screenshot')->store(
                "payment-screenshots/{$course->id}/" . $now->format('Y/m'),
                'public'
            );

            $password = strtoupper(Str::random(10));

            Enrollment::create([
                'course_id'         => $course->id,
                'full_name'         => $validated['full_name'],
                'email'             => $validated['email'],
                'phone'             => $validated['phone'],
                'payment_method_id' => $validated['payment_method'],
                'reference_code'    => $validated['reference_code'],
                'screenshot_path'   => $path,
                'screenshot_url'    => Storage::url($path),
                'amount_paid'       => $course->discounted_price_npr,
                'password'          => bcrypt($password),
                'plain_password'    => $password,
                'status'            => 'pending',
                'enrolled_at'       => $now,
            ]);

            $course->increment('enrolled_seats');
            Cache::forget('frontend_courses_all');

            return redirect()->route('courses.show', $course->slug)
                ->with('success', 'Enrolled successfully!')
                ->with('password', $password)
                ->with('payment_amount', $course->discounted_price_npr)
                ->with('payment_method', $paymentMethod->method_name . ' - ' . $paymentMethod->account_holder)
                ->with('reference_code', $validated['reference_code']);

        } catch (\Exception $e) {
            Log::error('Enrollment failed: ' . $e->getMessage());

            if (isset($path) && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }

            return back()->withInput()->with('error', 'Enrollment failed. Try again.');
        }
    }

    private function enhanceCourse(Course $course): Course
    {
        $now = Carbon::now('Asia/Kathmandu');

        $course->duration_days        = $this->calculateDuration($course);
        $course->original_price_npr   = $course->price ?? 0;
        $course->discounted_price_npr = $course->price ?? 0;
        $course->available_seats      = ($course->total_seats ?? 0) - ($course->enrolled_seats ?? 0);
        $course->photo                = $course->photo ?? 'courses/default.jpg';

        $discount = 0;
        if (
            $course->discount_percentage > 0 &&
            $course->discount_valid_from &&
            $course->discount_valid_to &&
            $now->between(
                Carbon::parse($course->discount_valid_from),
                Carbon::parse($course->discount_valid_to)->endOfDay()
            )
        ) {
            $discount = (float) $course->discount_percentage;
        }

        if ($discount > 0) {
            $course->discounted_price_npr = round($course->original_price_npr * (1 - $discount / 100), 2);
        }

        return $course;
    }

    private function calculateDuration(Course $course): int
    {
        try {
            $start = $course->start_date ? Carbon::parse($course->start_date) : now();
            $end   = $course->end_date ? Carbon::parse($course->end_date) : $start;
            return $start->diffInDays($end) + 1;
        } catch (\Exception $e) {
            return 0;
        }
    }
}
