<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class TermsController extends Controller
{

    public function show()
{
    // Fetch the first company record from the database
    $company = Company::first();

    // Fallback to default values if no company record exists
    // if (!$company) {
    //     $company = (object) [
    //         'name' => 'Default Company Name',
    //         'address' => 'Default Address',
    //         'email' => 'contact@default.com',
    //         'phone' => 'N/A',
    //         'website' => 'https://www.default.com',
    //         'legalName' => 'Default Legal Name',
    //     ];
    // }

    $lastUpdated = 'January 1, 2023';

    return view('frontend.terms_conditions', compact('company', 'lastUpdated'));
}
}
