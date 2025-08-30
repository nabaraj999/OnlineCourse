<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class PrivacyPolicyeController extends Controller
{
   public function show()
{
    // Fetch the first company record from the database
    $company = Company::first();


    $lastUpdated = 'January 1, 2023';

    return view('frontend.PrivacyPolicy', compact('company', 'lastUpdated'));
}
}
