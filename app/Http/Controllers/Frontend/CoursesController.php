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

            // Check if current user/email/phone has pending enrollment
            $hasPending = false;
            if (auth()->check()) {
                $hasPending = Enrollment::where('course_id', $course->id)
                    ->where('email', auth()->user()->email)
                    ->where('status', 'pending')
                    ->exists();
            }

            return view('frontend.courses-show', compact('course', 'payment_methods', 'hasPending'));
        } catch (\Exception $e) {
            Log::error("Course show error [slug: $slug]: " . $e->getMessage());
            return redirect()->route('courses.index')
                ->with('error', 'Course not found or currently unavailable.');
        }
    }

    // FINAL ENROLL STORE - PENDING ONLY (SEAT RESERVED ON APPROVAL)
    public function enrollStore(Request $request)
    {
        $request->validate([
            'course_id'         => 'required|exists:courses,id',
            'full_name'         => 'required|string|max:255',
            'email'             => 'required|email|max:255',
            'phone'             => 'required|string|regex:/^\+?[0-9]{10,15}$/',
            'reference_code'    => 'required|string|max:50|unique:enrollments,reference_code',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'screenshot'        => 'required|image|mimes:jpg,jpeg,png|max:5048',
        ]);

        return DB::transaction(function () use ($request) {
            $course = Course::where('id', $request->course_id)
                ->where('active_status', 'active')
                ->lockForUpdate()
                ->firstOrFail();

            $course = $this->enhanceCourse($course);

            // Check if seats are actually available (only approved count)
            if ($course->total_seats <= $course->enrolled_seats) {
                throw ValidationException::withMessages([
                    'course_id' => 'Sorry, this course is fully booked!'
                ]);
            }

            // Prevent multiple approved enrollments
            $alreadyApproved = Enrollment::where('course_id', $course->id)
                ->where('status', 'approved')
                ->where(function ($q) use ($request) {
                    $q->where('email', $request->email)
                      ->orWhere('phone', $request->phone);
                })->exists();

            if ($alreadyApproved) {
                throw ValidationException::withMessages([
                    'email' => 'You are already enrolled and approved in this course!'
                ]);
            }

            // Allow only ONE pending enrollment
            $hasPending = Enrollment::where('course_id', $course->id)
                ->where('status', 'pending')
                ->where(function ($q) use ($request) {
                    $q->where('email', $request->email)
                      ->orWhere('phone', $request->phone);
                })->exists();

            if ($hasPending) {
                throw ValidationException::withMessages([
                    'email' => 'You already have a pending enrollment. Please wait for approval or contact support.'
                ]);
            }

            // Upload screenshot
            $screenshot = $request->file('screenshot');
            $filename = time() . '_' . Str::random(10) . '.' . $screenshot->getClientOriginalExtension();
            $path = $screenshot->storeAs('enrollments/screenshots', $filename, 'public');

            // Generate password
            $plainPassword = strtoupper(Str::random(8));

            // Create PENDING enrollment (DO NOT increment seats yet!)
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

            Log::info('New pending enrollment', [
                'id' => $enrollment->id,
                'course' => $course->title,
                'name' => $request->full_name
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Enrollment submitted! We will verify your payment and approve within 24 hours.',
                'plain_password' => $plainPassword,
                'note' => 'Your seat will be confirmed after admin approval.'
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
        if ($course->discount_percentage > 0 && $course->discount_valid_from && $course->discount_valid_to) {
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
