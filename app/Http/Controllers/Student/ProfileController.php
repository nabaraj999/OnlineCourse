<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $student = Auth::user(); // This is your Enrollment model
        return view('student.profile.index', compact('student'));
    }

    public function update(Request $request)
    {
        $student = Auth::user();

        $request->validate([
            'full_name' => 'required|string|max:255',
            'email'     => 'required|email|unique:enrollments,email,' . $student->id,
            'phone'     => 'required|string|regex:/^[\+]?[0-9]{10,15}$/',
            'password'  => 'nullable|confirmed|min:8',
        ]);

        $student->update([
            'full_name' => $request->full_name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'password'  => $request->filled('password') ? Hash::make($request->password) : $student->password,
        ]);

        return back()->with('success', 'Profile updated successfully!');
    }
}
