<?php
// app/Http/Controllers/CourseController.php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\PaymentMethod;
use App\Models\PaymentMethods;

class CourseController extends Controller
{
    public function show(Course $course)
    {
        // Only show active courses
        if ($course->active_status !== 'active') {
            abort(404);
        }

        // Load teacher & active payment methods
        $course->load('teacher');
        $paymentMethods = PaymentMethods::where('active', true)
            ->orderBy('sort_order')
            ->get();

        // Check if already enrolled
        $isEnrolled = auth()->check() && auth()->user()->allEnrollments()
            ->where('course_id', $course->id)
            ->where('status', 'approved')
            ->exists();

        return view('student.show', compact('course', 'paymentMethods', 'isEnrolled'));
    }
}
