<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\Enrollment;

class MyCourseController extends Controller
{
    public function index()
    {
        $student = Auth::user();

        $enrollments = Enrollment::where('email', $student->email)
            ->where('status', 'approved')
            ->with('course')
            ->latest('enrolled_at')
            ->get();

        $courses = $enrollments->map(function ($enrollment) {
            $course = $enrollment->course;
            if (!$course) return null;

            $now = now();
            $start = $course->start_date ? \Carbon\Carbon::parse($course->start_date) : null;
            $end = $course->end_date ? \Carbon\Carbon::parse($course->end_date) : null;

            $status = 'upcoming';
            $color = 'bg-blue-600';

            if ($start && $end) {
                if ($now->between($start, $end)) {
                    $status = 'ongoing'; $color = 'bg-green-600';
                } elseif ($now->gt($end)) {
                    $status = 'completed'; $color = 'bg-gray-600';
                }
            } elseif ($start && $now->gte($start)) {
                $status = 'ongoing'; $color = 'bg-green-600';
            }

            return (object)[
                'id'         => $course->id,
                'slug'       => $course->slug,
                'title'      => $course->title,
                'photo'      => $course->photo,
                'start_date' => $start?->format('d M Y'),
                'end_date'   => $end?->format('d M Y'),
                'status'     => $status,
                'color'      => $color,
            ];
        })->filter();

        return view('student.mycourses.index', compact('courses'));
    }

    public function show(Course $course)
    {
        $student = Auth::user();

        // Security: Only allow access if enrolled and approved
        $enrollment = Enrollment::where('email', $student->email)
            ->where('course_id', $course->id)
            ->where('status', 'approved')
            ->firstOrFail();

        // You can later load lessons, videos, progress, etc.
        return view('student.mycourses.show', compact('course', 'enrollment'));
    }
}
