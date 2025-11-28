<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Support\Facades\Auth;
use PDF;

class PaymentReceiptController extends Controller
{
    public function index()
    {
        $receipts = Auth::user()->allEnrollments()  // ← Fixed: was enrollments()
            ->where('status', 'approved')
            ->with('course')
            ->latest('enrolled_at')
            ->get();

        return view('student.payment-receipts', compact('receipts'));
    }

    public function show($enrollmentId)
    {
        $receipt = Auth::user()->allEnrollments()
            ->where('status', 'approved')
            ->with('course')
            ->findOrFail($enrollmentId);

        $company = \App\Models\Company::firstOrFail();

        return view('student.receipt-print', compact('receipt', 'company'));
    }

    public function pdf($enrollmentId)
    {
        $receipt = Auth::user()->allEnrollments()
            ->where('status', 'approved')
            ->with('course')
            ->findOrFail($enrollmentId);

        $company = \App\Models\Company::firstOrFail();

        $pdf = FacadePdf::loadView('student.receipt-print', compact('receipt', 'company'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('Receipt_'.$receipt->reference_code.'.pdf');
    }
}
