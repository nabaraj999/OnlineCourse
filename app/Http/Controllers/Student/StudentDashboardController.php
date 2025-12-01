<?php
// app/Http/Controllers/Student/StudentDashboardController.php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\PaymentMethod;
use App\Models\PaymentMethods;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $student = Auth::user();

        // 1. Enrolled Courses Count
        $enrolledCoursesCount = Enrollment::where('email', $student->email)
            ->where('status', 'approved')
            ->count();

        // 2. Recent Activities (Last 6 enrollments)
        $recentActivities = Enrollment::where('email', $student->email)
            ->with('course')
            ->latest('enrolled_at')
            ->take(6)
            ->get()
            ->map(function ($enrollment) {
                $courseName = $enrollment->course?->title ?? 'Unknown Course';

                return [
                    'message' => match ($enrollment->status) {
                        'approved' => "Enrolled in <strong>{$courseName}</strong>",
                        'pending'  => "Payment submitted for <strong>{$courseName}</strong>",
                        'rejected' => "Enrollment rejected: <strong>{$courseName}</strong>",
                        default    => "Status updated: {$courseName}"
                    },
                    'color' => match ($enrollment->status) {
                        'approved' => 'bg-green-500',
                        'pending'  => 'bg-yellow-500',
                        'rejected' => 'bg-red-500',
                        default    => 'bg-gray-500'
                    },
                    'time' => $enrollment->enrolled_at?->diffForHumans() ?? 'Just now'
                ];
            });

        // 3. Available Courses (Not yet enrolled by this student)
        $enrolledCourseIds = Enrollment::where('email', $student->email)
            ->where('status', 'approved')
            ->pluck('course_id')
            ->toArray();

        $availableCourses = Course::where('active_status', 'active')
            ->whereNotIn('id', $enrolledCourseIds)
            ->with('teacher')
            ->latest()
            ->take(6)
            ->get();

        // 4. Active Payment Methods
        $paymentMethods = PaymentMethods::where('active', true)
            ->orderBy('sort_order')
            ->get();

        return view('student.dashboard', compact(
            'student',
            'enrolledCoursesCount',
            'recentActivities',
            'availableCourses',
            'paymentMethods'
        ));
    }
}
