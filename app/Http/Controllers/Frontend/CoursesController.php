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
use Illuminate\Support\Facades\DB;

class CoursesController extends Controller
{
    public function show($slug)
    {
        try {
            // ── 1. Course (cached) ─────────────────────────────────────
            $course = Cache::remember("course_{$slug}", 600, function () use ($slug) {
                return Course::with([
                    'teacher' => fn($q) => $q->withDefault(['name' => 'N/A']),
                    'company' => fn($q) => $q->withDefault(['name' => 'N/A']),
                ])
                    ->where('active_status', 'active')
                    ->where('slug', $slug)
                    ->firstOrFail();
            });

            $course = $this->enhanceCourse($course);

            // Only ACTIVE methods, cached, NO map()
            $selected_payment_method = Cache::remember('active_payment_method', 3600, function () {
                return PaymentMethods::active()
                    ->orderBy('sort_order')
                    ->first(); // ← first active only
            });

            return view('frontend.courses-show', compact('course', 'selected_payment_method'));
        } catch (\Exception $e) {
            Log::error("Course show error [{$slug}]: " . $e->getMessage());
            return redirect()->route('courses.index')
                ->with('error', 'Course not found.');
        }
    }

    public function enroll(Request $request, Course $course)
    {
        if ($course->active_status !== 'active') {
            return back()->with('error', 'This course is no longer available.');
        }

        $validated = $request->validate([
            'full_name'          => 'required|string|max:255',
            'email'              => 'required|email|max:255',
            'phone'              => 'required|regex:/^(\+977)?[0-9]{10}$/',
            'payment_method'     => 'required|exists:payment_methods,id',
            'reference_code'     => 'required|string|max:100|unique:enrollments,reference_code',
            'payment_screenshot' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ], [
            'phone.regex' => 'Valid Nepali number required (e.g., 98XXXXXXXX)',
            'reference_code.unique' => 'This Transaction ID is already used.',
        ]);

        return DB::transaction(function () use ($request, $course, $validated) {
            $course = $course->lockForUpdate()->find($course->id);
            $available = ($course->total_seats ?? 0) - ($course->enrolled_seats ?? 0);

            if ($available <= 0) {
                throw new \Exception('No seats left!');
            }

            $course = $this->enhanceCourse($course->fresh());
            $paymentMethod = PaymentMethods::findOrFail($validated['payment_method']);
            $now = Carbon::now('Asia/Kathmandu');

            $path = $request->file('payment_screenshot')->storeAs(
                "screenshots/{$course->id}/{$now->format('Y/m')}",
                $request->file('payment_screenshot')->hashName(),
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
            Cache::forget("course_{$course->slug}");

            return redirect()->route('courses.show', $course->slug)
                ->with('success', 'Enrolled successfully! Check your details below.')
                ->with('password', $password)
                ->with('payment_amount', $course->discounted_price_npr)
                ->with('payment_method', $paymentMethod->method_name . ' - ' . $paymentMethod->account_holder)
                ->with('reference_code', $validated['reference_code']);
        });
    }

    private function enhanceCourse(Course $course): Course
    {
        $now = Carbon::now('Asia/Kathmandu');

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
}
