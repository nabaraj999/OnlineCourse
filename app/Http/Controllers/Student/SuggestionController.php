<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuggestionController extends Controller
{
    public function index()
    {
        // THIS IS THE ONLY SAFE WAY WHEN USING web GUARD
        $user = Auth::user();

        // If somehow not logged in → redirect to login (never null error)
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in first.');
        }

        $suggestions = $user->suggestions()
            ->latest()
            ->paginate(10);

        return view('student.suggestions.index', compact('suggestions'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return back()->with('error', 'You must be logged in to submit a suggestion.');
        }

        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        $user->suggestions()->create([
            'subject' => $request->subject,
            'message' => $request->message,
            'status'  => 'pending',
        ]);

        return back()->with('success', 'Thank you! Your suggestion has been submitted.');
    }
}
