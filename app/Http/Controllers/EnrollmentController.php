<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\PaymentMethod;
use App\Models\PaymentMethods;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function create($courseId)
    {
        $course = Course::findOrFail($courseId);
        $paymentMethods = PaymentMethods::where('active', true)->get();
        return view('courses.course_enroll', compact('course', 'paymentMethods'));
    }

    public function store(Request $request, $courseId)
    {
        $course = Course::findOrFail($courseId);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'comments' => 'nullable|string|max:1000',
        ]);

        // Create enrollment record (status pending)
        $enrollment = Enrollment::create([
            'course_id' => $courseId,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'comments' => $validated['comments'],
            'status' => 'pending',
        ]);

        // Redirect to payment page or handle payment here
        // For now, redirect with success and enrollment ID
        return redirect()->route('enrollments.payment', ['enrollment' => $enrollment->id])
                         ->with('success', 'Enrollment created! Proceed to payment.');
    }

    public function payment($enrollmentId)
    {
        $enrollment = Enrollment::with('course')->findOrFail($enrollmentId);
        $paymentMethods = PaymentMethods::where('active', true)->get();
        return view('enrollments.payment', compact('enrollment', 'paymentMethods'));
    }

    // Add methods for payment callbacks (e.g., Khalti verify)
    public function khaltiCallback(Request $request)
    {
        // Verify Khalti payment, update enrollment status
        // Use Khalti API to verify
        // Example: if verified, $enrollment->update(['status' => 'paid', 'transaction_id' => $pidx]);
        return redirect()->route('courses.show', $enrollment->course_id)->with('success', 'Payment successful!');
    }
}
