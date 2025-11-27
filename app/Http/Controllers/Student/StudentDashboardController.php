<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Enrollment;

class StudentDashboardController extends Controller
{
    public function index()
    {
        // Get the authenticated student (assuming you're guarding with 'web' and User model has student info)
        $student = Auth::guard('web')->user();

        if (!$student) {
            Auth::guard('web')->logout();
            return redirect()->route('student.login')->with('error', 'Please log in again.');
        }

        // Fetch approved enrollment count
        $enrolledCoursesCount = Enrollment::where('email', $student->email)
            ->where('status', 'approved')
            ->count();

        // Recent activities
        $recentActivities = Enrollment::where('email', $student->email)
            ->with('course')
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
                    'time'    => $enrollment->enrolled_at?->diffForHumans() ?? 'Just now',
                    'color'   => $color,
                ];
            });

        // Optional: Get student's department from first approved enrollment or user profile
        $department = optional(Enrollment::where('email', $student->email)
            ->where('status', 'approved')
            ->with('course')
            ->first()?->course)?->department ?? $student->department ?? 'Student';

        // Or if you have a `program` or `department` column directly on users table:
        // $department = $student->department ?? $student->program ?? 'General Studies';

        return view('student.dashboard', compact(
            'student',
            'enrolledCoursesCount',
            'recentActivities',
            'department'
        ));
    }
}
