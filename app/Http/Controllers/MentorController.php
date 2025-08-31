<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Support\Facades\Cache;

class MentorController extends Controller
{
    /**
     * Display a listing of active mentors.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        try {
            $teachers = Cache::remember('active_teachers', 60, function () {
                return Teacher::where('account_status', 'active')->get();
            });
            return view('frontend.mentors', compact('teachers'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Unable to fetch mentors. Please try again later.');
        }
    }
}
