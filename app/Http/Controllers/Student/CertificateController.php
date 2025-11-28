<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Enrollment;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
public function index()
{
    $certificates = Auth::user()->certificate()
        ->where('is_issued', true)
        ->with('enrollment.course')
        ->latest('issued_at')
        ->get();

    return view('student.certificates.index', compact('certificates'));
}

public function download($id)
{
    $certificate = Certificate::with('enrollment.course')->findOrFail($id);

    if ($certificate->enrollment->email !== Auth::user()->email || !$certificate->is_issued) {
        abort(403);
    }

    $pdf = FacadePdf::loadView('student.certificates.simple', compact('certificate'));
    $pdf->setPaper('a4', 'landscape');
    $pdf->setOptions([
        'defaultFont' => 'Helvetica',
        'isRemoteEnabled' => true,
        'isHtml5ParserEnabled' => true,
    ]);

    return $pdf->download("Certificate-{$certificate->certificate_number}.pdf");
}

}
