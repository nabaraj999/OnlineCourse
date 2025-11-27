<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PaymentReceiptController extends Controller
{
    // Add this line — THIS IS REQUIRED
    public function __invoke()
    {
        $receipts = Auth::user()->enrollments()
            ->where('status', 'approved')
            ->with('course')
            ->latest('enrolled_at')
            ->get();

        return view('student.payment-receipts', compact('receipts'));
    }
    public function index()
{
    $receipts = Auth::user()->enrollments()
        ->where('status', 'approved')
        ->with('course')
        ->latest('enrolled_at')
        ->get();

    return view('student.payment-receipts', compact('receipts'));
}

public function show($enrollmentId)
{
    $receipt = Auth::user()->enrollments()
        ->where('status', 'approved')
        ->with('course')
        ->findOrFail($enrollmentId);

    $company = \App\Models\Company::first();

    return view('student.receipt-print', compact('receipt', 'company'));
}

public function pdf($enrollmentId)
{
    $receipt = Auth::user()->enrollments()
        ->where('status', 'approved')
        ->with('course')
        ->findOrFail($enrollmentId);

    $company = \App\Models\Company::first();

    // We'll use DOMPDF (install below)
    $pdf = \PDF::loadView('student.receipt-print', compact('receipt', 'company'));
    $pdf->setPaper('A4', 'portrait');

    return $pdf->download('Receipt_'.$receipt->reference_code.'.pdf');
}
}
