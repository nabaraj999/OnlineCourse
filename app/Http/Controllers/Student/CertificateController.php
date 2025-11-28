<?php
// app/Http/Controllers/Student/CertificateController.php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    public function index()
    {
        $student = Auth::user(); // Your Enrollment model

        $certificates = $student->certificates()
            ->with('course')
            ->where('is_issued', true)
            ->latest('issued_at')
            ->get();

        $enrolledCourses = $student->courses()
            ->wherePivot('status', 'approved')
            ->withPivot('enrolled_at')
            ->get();

        return view('student.certificates.index', compact('certificates', 'enrolledCourses'));
    }
}
