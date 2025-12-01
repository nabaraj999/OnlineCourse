<?php
// app/Http/Controllers/Student/CourseDetailController.php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseDetailController extends Controller
{
    public function show(Course $course)
    {
        // Security: Only allow if student is enrolled & approved
        $enrollment = auth()->user()->allEnrollments()
            ->where('course_id', $course->id)
            ->where('status', 'approved')
            ->first();

        if (!$enrollment) {
            abort(403, 'You are not enrolled in this course.');
        }

        // Get all published materials, ordered properly
        $materials = $course->courseMaterials()
            ->where('is_published', true)
            ->orderBy('resource_date', 'desc')
            ->orderBy('sort_order', 'asc')
            ->get();

        return view('student.course-detail', compact('course', 'materials', 'enrollment'));
    }
}
