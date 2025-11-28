{{-- resources/views/certificates/modern-premium.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Certificate - {{ $certificate->certificate_number }}</title>
    <style>
        @page { size: A4 landscape; margin: 0; }
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', 'Helvetica Neue', Arial, sans-serif;
            width: 297mm;
            height: 210mm;
            background: #0f172a;
            color: #e2e8f0;
            position: relative;
            overflow: hidden;
        }

        /* Premium Animated Background */
        .bg {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 40%, #0f766e 100%);
            z-index: 0;
        }

        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.25;
        }
        .orb1 { width: 500px; height: 500px; background: #1e40af; top: -150px; right: -150px; }
        .orb2 { width: 400px; height: 400px; background: #0f766e; bottom: -100px; left: -100px; }
        .orb3 { width: 300px; height: 300px; background: #d97706; top: 40%; left: 10%; }

        .grid {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.02) 1px, transparent 1px);
            background-size: 60px 60px;
            z-index: 1;
        }

        /* Glass Card */
        .card {
            position: absolute;
            inset: 15mm 25mm;
            background: rgba(15, 23, 42, 0.45);
            backdrop-filter: blur(16px);
            border: 1.5px solid rgba(255, 255, 255, 0.12);
            border-radius: 28px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
            z-index: 10;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 28px;
            padding: 2px;
            background: linear-gradient(135deg, #60a5fa, #34d399, #fbbf24);
            mask: linear-gradient(#fff 0 0) padding-box, linear-gradient(#fff 0 0);
            mask-composite: exclude;
            -webkit-mask-composite: destination-out;
            opacity: 0.4;
        }

        .content {
            position: relative;
            height: 100%;
            padding: 40px 60px;
            display: flex;
            flex-direction: column;
        }

        /* Header - Top Section */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(96, 165, 250, 0.3);
        }

        .logo img {
            height: 85px;
            filter: drop-shadow(0 4px 12px rgba(0,0,0,0.5));
        }

        .meta {
            text-align: right;
            font-size: 13px;
            color: #94a3b8;
        }
        .meta strong { color: #60a5fa; font-weight: 700; }

        /* Center - Big Name & Course */
        .center {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 30px 0;
        }

        .title {
            font-size: 68px;
            font-weight: 900;
            background: linear-gradient(135deg, #60a5fa, #34d399, #fbbf24);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: 4px;
            margin-bottom: 20px;
            text-transform: uppercase;
        }

        .student-name {
            font-size: 82px;
            font-weight: 900;
            color: #ffffff;
            font-family: Georgia, serif;
            font-style: italic;
            letter-spacing: -1px;
            text-shadow: 0 0 40px rgba(96, 165, 250, 0.5);
            margin: 20px 0;
        }

        .course {
            font-size: 44px;
            color: #fbbf24;
            font-weight: 800;
            margin: 15px 0 30px;
        }

        /* Bottom Footer - One Line */
        .footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 20px;
            border-top: 1px solid rgba(96, 165, 250, 0.3);
            font-size: 16px;
        }

        .footer-date strong { color: #60a5fa; font-weight: 700; }
        .footer-badge { width: 100px; }
        .footer-badge img { width: 100%; height: auto; }
        .footer-verified { text-align: right; }
        .footer-verified strong { color: #34d399; font-weight: 800; font-size: 17px; margin-bottom: 20px; }

        /* Print Mode */
        @media print {
            .orb, .grid { display: none; }
            body, .bg { background: #000 !important; }
            .card { background: rgba(15,23,42,0.9) !important; }
        }
    </style>
</head>
<body>

@php
    $company = \App\Models\Company::firstOrFail();
    $logoPath = $company->logo ? storage_path('app/public/' . $company->logo) : public_path('images/logo.png');
@endphp

<div class="bg"></div>
<div class="orb orb1"></div>
<div class="orb orb2"></div>
<div class="orb orb3"></div>
<div class="grid"></div>

<div class="card">
    <div class="content">

        <!-- Top: Header -->
        <div class="header">
            <div class="logo">
                @if($company->logo && file_exists($logoPath))
                    <img src="{{ Storage::url($company->logo) }}" alt="{{ $company->name }}">
                @else
                    <h2 style="color:#60a5fa;font-size:38px;font-weight:900;">{{ strtoupper($company->name) }}</h2>
                @endif
            </div>
            <div class="meta">
                <div><strong>Certificate No:</strong> {{ $certificate->certificate_number }}</div>
                <div><strong>Issue Date:</strong> {{ $certificate->issued_at->format('d M Y') }}</div>
            </div>
        </div>

        <!-- Middle: Big Name & Course -->
        <div class="center">
            <div class="title">Certificate of Completion</div>
            <div class="student-name">{{ $certificate->enrollment->full_name }}</div>
            <div style="font-size:20px;color:#cbd5e1;margin:15px 0;">has successfully completed the course</div>
            <div class="course">{{ $certificate->enrollment->course->title }}</div>
            <div style="margin-top:20px;font-size:18px;color:#94a3b8;max-width:850px;">
                Awarded in recognition of outstanding dedication and mastery in the subject.
            </div>
        </div>

        <!-- Bottom: One Line Footer -->
        <div class="footer">
            <div class="footer-date">
                <strong>Date of Certification:</strong> {{ $certificate->issued_at->format('d F Y') }}
                <strong> ,  Verified by <strong>{{ $company->name }}</strong></strong>
            </div>
        </div>

    </div>
</div>

</body>
</html>
