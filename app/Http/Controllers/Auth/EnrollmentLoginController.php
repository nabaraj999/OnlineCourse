<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrollmentLoginController extends Controller
{
    // Optional: only show login page to guests (safe even if middleware() doesn't exist)
    // public function __construct()
    // {
    //     $this->middleware('guest:web')->except('logout');
    // }

    // Show login form
    public function showLoginForm()
    {
        return view('auth.enrollment-login');
    }

    // ←←← THIS IS THE ONLY METHOD NAME THAT MATTERS ←←←
    public function login(Request $request)   // ← Must be "login", NOT "studentlogin"
    {
        $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string',
        ]);

        $field = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'reference_code';

        if (Auth::guard('web')->attempt([
            $field     => $request->login,
            'password' => $request->password
        ], $request->filled('remember'))) {

            $user = Auth::guard('web')->user();

            if ($user->status !== 'approved') {
                Auth::guard('web')->logout();
                return back()->withErrors(['login' => 'Your enrollment is pending approval.']);
            }

            // FINAL FIX: NO intended() → go straight to dashboard
            return redirect('/student/dashboard');
        }

        return back()->withErrors(['login' => 'Email/Reference Code or password is incorrect.']);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
