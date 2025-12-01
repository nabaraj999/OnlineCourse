<?php
// app/Http/Controllers/EnrollmentController.php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\PaymentMethod;
use App\Models\PaymentMethods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pest\Support\Str;

class EnrollmentController extends Controller
{
    public function create(Course $course)
    {
        // Prevent re-enrollment
        if (Auth::check()) {
            $exists = Auth::user()->allEnrollments()
                ->where('course_id', $course->id)
                ->exists();

            if ($exists) {
                return redirect()->route('student.my-courses')
                    ->with('info', 'You are already enrolled in this course.');
            }
        }

        $paymentMethods = PaymentMethods::where('active', true)
            ->orderBy('sort_order')
            ->get();

        return view('student.enrollment.create', compact('course', 'paymentMethods'));
    }
    public function store(Request $request)
{
    $request->validate([
        'course_id'          => 'required|exists:courses,id',
        'full_name'          => 'required|string|max:255',
        'email'              => 'required|email',
        'phone'              => 'required|string|max:15',
        'payment_method_id'  => 'required|exists:payment_methods,id',
        'screenshot'         => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $course = Course::findOrFail($request->course_id);

    // Prevent duplicate enrollment
    $exists = Enrollment::where('email', $request->email)
        ->where('course_id', $course->id)
        ->exists();

    if ($exists) {
        return back()->with('error', 'You have already enrolled in this course.');
    }

    // Handle screenshot upload
    $screenshotPath = $request->file('screenshot')->store('screenshots', 'public');

    // Generate unique reference code
    $referenceCode = 'REF-' . strtoupper(Str::random(8));



    Enrollment::create([
        'course_id'         => $course->id,
        'payment_method_id' => $request->payment_method_id,
        'full_name'         => $request->full_name,
        'email'             => $request->email,
        'phone'             => $request->phone,
        'reference_code'    => $referenceCode,
        'screenshot_path'   => $screenshotPath,
        'screenshot_url'    => asset('storage/' . $screenshotPath),
        'amount_paid'       => $course->price,
        'status'            => 'pending',
        'enrolled_at'       => now(),
    ]);

    return redirect()->route('student.my-courses')
        ->with('success', "Enrollment submitted successfully! Reference Code: <strong>{$referenceCode}</strong>. Wait for approval.");
}
}
