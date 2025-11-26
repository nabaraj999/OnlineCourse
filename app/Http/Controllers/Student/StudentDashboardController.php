<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Enrollment;

class StudentDashboardController extends Controller
{
    public function index()
    {
        // Get the currently logged-in student (from enrollments table)
        $student = Auth::guard('web')->user();

        // If somehow not logged in (shouldn't happen due to middleware)
        if (!$student) {
            Auth::guard('web')->logout();
            return redirect()->route('student.login')->with('error', 'Please log in again.');
        }

        // Only count APPROVED enrollments
        $enrolledCoursesCount = Enrollment::where('email', $student->email)
            ->where('status', 'approved')
            ->count();

        // Recent activities: last 5 enrollment actions for this student
        $recentActivities = Enrollment::where('email', $student->email)
            ->with('course') // make sure you have ->belongsTo(Course::class) in Enrollment model
            ->latest('enrolled_at')
            ->take(6)
            ->get()
            ->map(function ($enrollment) {
                $courseName = $enrollment->course?->title ?? 'Unknown Course';

                $message = '';
                $color   = 'bg-gray-500';

                switch ($enrollment->status) {
                    case 'approved':
                        $message = "Successfully enrolled in <strong>{$courseName}</strong>";
                        $color   = 'bg-green-500';
                        break;
                    case 'pending':
                        $message = "Enrollment request sent for <strong>{$courseName}</strong>";
                        $color   = 'bg-yellow-500';
                        break;
                    case 'rejected':
                        $message = "Enrollment rejected for <strong>{$courseName}</strong>";
                        $color   = 'bg-red-500';
                        break;
                    default:
                        $message = "Status updated: {$courseName}";
                }

                return [
                    'message' => $message,
                    'time'    => $enrollment->enrolled_at->diffForHumans(), // e.g., "2 hours ago"
                    'color'   => $color,
                ];
            });

        // Pass data to Blade view
        return view('student.dashboard', compact(
            'enrolledCoursesCount',
            'recentActivities'
        ));
    }
}
