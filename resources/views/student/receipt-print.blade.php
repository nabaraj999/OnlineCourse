<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - {{ $receipt->reference_code }}</title>
    <link rel="icon" type="image/png/jpg" href="{{ Storage::url($company->favicon ?? 'default.png') }}" alt="FinHedge Logo" class="h-auto w-auto">
    <!-- Bootstrap + Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

    <!-- Railway Font -->
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- jsPDF + html2canvas -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>

    <style>
        body {
            font-family: 'Raleway', sans-serif;
            background: #f9f9f9;
            color: #2c3e50;
            margin: 0;
            padding: 0;
        }
        .receipt {
            background: white;
            padding: 28px 35px;
            border-radius: 10px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
            max-width: 800px;
            margin: 20px auto;
            border: 1px solid #e0e0e0;
        }
        .logo-img {
            height: 52px;
            width: auto;
        }
        .primary-btn {
            background: #1e40af !important;
            color: white !important;
            font-weight: 600;
            border-radius: 8px;
            padding: 10px 22px;
        }
        .company-info {
            line-height: 1.25;
            margin: 6px 0 0 0;
        }
        .company-info p { margin: 0; padding: 0; font-size: 0.9rem; }
        .text-xs { font-size: 0.82rem; }
        .text-sm { font-size: 0.92rem; }

        @media print {
            body, html { margin: 0; padding: 0; background: white; }
            .no-print { display: none !important; }
            .receipt { box-shadow: none; border: none; margin: 0; padding: 25px 30px; }
            @page { size: A4 portrait; margin: 1cm; }
        }
    </style>
</head>
<body>

@php
    $company = $company ?? \App\Models\Company::first();
    $originalPrice = $receipt->course->price;
    $paidAmount = $receipt->amount_paid;
    $discount = $originalPrice - $paidAmount;
@endphp

<div class="container-fluid">
    <div class="text-end mb-3 no-print">
        <button onclick="downloadReceipt()" class="btn primary-btn shadow">
            Print / Download PDF
        </button>
    </div>

    <div id="receiptContent" class="receipt">

        <!-- Title -->
        <div class="text-center mb-3">
            <h3 class="fw-bold text-primary mb-0" style="font-size: 1.7rem;">
                Payment Receipt
            </h3>
        </div>

        <!-- Company Info – Super Compact -->
        <div class="text-center company-info mb-3">
            @if($company?->logo)
                <img src="{{ asset('storage/' . $company->logo) }}" class="logo-img mb-1" alt="Logo">
            @endif
            <h2 class="fw-bold mb-1" style="font-size: 1.45rem;">
                {{ $company?->name ?? 'Code IT' }}
            </h2>
            <p class="text-sm mb-0">{{ $company?->address ?? 'Prithvi Path, Dharan' }}</p>
            @if($company?->registration_number)
                <p class="text-xs mb-0"><strong>Reg No.</strong> {{ $company->registration_number }}</p>
            @endif
            @if($company?->pan_number)
                <p class="text-xs mb-0"><strong>PAN No.</strong> {{ $company->pan_number }}</p>
            @endif
        </div>

        <!-- Transaction Info -->
        <div class="d-flex justify-content-between mb-2 text-sm border-bottom pb-2">
            <div><strong>Transaction No:</strong> <span class="text-primary fw-bold">{{ $receipt->reference_code }}</span></div>
            <div><strong>Date:</strong> {{ $receipt->enrolled_at->format('d M Y, h:i A') }}</div>
        </div>

        <!-- Student Details -->
        <div class="row mb-3 text-sm">
            <div class="col-12">
                <div class="row g-1">
                    <div class="col-4 fw-600">Student</div><div class="col-8">: {{ $receipt->full_name }}</div>
                    <div class="col-4 fw-600">Phone</div><div class="col-8">: {{ $receipt->phone }}</div>
                    <div class="col-4 fw-600">Email</div><div class="col-8">: {{ $receipt->email }}</div>
                    <div class="col-4 fw-600">Address</div><div class="col-8">: {{ $company?->address ?? 'N/A' }}</div>
                    <div class="col-4 fw-600">Institution</div><div class="col-8">: <span class="text-primary fw-bold">{{ $company?->name }}</span></div>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-sm text-sm">
                <thead class="table-light">
                    <tr class="fw-bold">
                        <th>SN</th>
                        <th>Course</th>
                        <th>Course Fee</th>
                        <th>Qty</th>
                        <th>Sub Total</th>
                        <th>Discount</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center">1</td>
                        <td class="fw-bold">{{ Str::limit($receipt->course->title, 45) }}</td>
                        <td class="text-end">Rs. {{ number_format($originalPrice, 0) }}</td>
                        <td class="text-center">1</td>
                        <td class="text-end">Rs. {{ number_format($originalPrice, 0) }}</td>
                        <td class="text-end text-danger fw-bold">
                            @if($discount > 0) Rs. {{ number_format($discount, 0) }} @else - @endif
                        </td>
                        <td class="text-end text-success fw-bold">Rs. {{ number_format($paidAmount, 0) }}/-</td>
                    </tr>
                    <tr class="table-primary">
                        <td colspan="6" class="text-end fw-bold">Total Amount</td>
                        <td class="text-end text-success fw-bold">Rs. {{ number_format($paidAmount, 0) }}/-</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="text-center mt-4">
            <p class="fw-bold text-dark mb-0">Thank you for choosing {{ $company?->name ?? 'us' }}!</p>
        </div>
    </div>
</div>

<script>
function downloadReceipt() {
    const btn = document.querySelector('button');
    btn.disabled = true;
    btn.innerHTML = 'Generating...';

    html2canvas(document.getElementById('receiptContent'), {
        scale: 2.5,
        useCORS: true,
        backgroundColor: '#ffffff',
        width: 800,
        height: 1130
    }).then(canvas => {
        const img = canvas.toDataURL('image/jpeg', 1.0);
        const pdf = new jsPDF('p', 'mm', 'a4');  // Portrait
        const width = pdf.internal.pageSize.getWidth();
        const height = pdf.internal.pageSize.getHeight();

        pdf.addImage(img, 'JPEG', 0, 0, width, height);
        pdf.save('Receipt_{{ $receipt->reference_code }}.pdf');

        btn.disabled = false;
        btn.innerHTML = 'Print / Download PDF';
    }).catch(() => {
        alert('PDF generation failed');
        btn.disabled = false;
        btn.innerHTML = 'Print / Download PDF';
    });
}
</script>

</body>
</html>
