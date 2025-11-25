<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;  // ← THIS MUST BE THIS LINE
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class EnrollmentLoginController extends Controller  // ← MUST extend Controller
{
    public function __construct()
    {
        if (method_exists($this, 'middleware')) {
            $this->middleware('guest')->except('logout');
        }
    }

    public function showLoginForm()
    {
        return view('auth.enrollment-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $field = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'reference_code';

        if (Auth::attempt([$field => $request->login, 'password' => $request->password], $request->filled('remember'))) {

            $user = Auth::user();

            if ($user->status !== 'approved') {
                Auth::logout();
                return back()->withErrors(['login' => 'Your account is not approved yet.']);
            }

            return redirect()->intended('/student/dashboard');
        }

        return back()->withErrors(['login' => 'Invalid credentials.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
