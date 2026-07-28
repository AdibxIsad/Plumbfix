<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Record #{{ $jobRecord->jobRecordID }} Report — Plumbfix</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Outfit', sans-serif;
            color: #1e293b;
            background-color: #ffffff;
            line-height: 1.5;
            padding: 40px;
            font-size: 14px;
        }

        .report-container {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 40px;
            background-color: #ffffff;
        }

        /* ── Header Styling ── */
        .report-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #3b82f6;
            padding-bottom: 24px;
            margin-bottom: 30px;
        }

        .brand-section {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-logo {
            width: 46px;
            height: 46px;
            background-color: #2563eb;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 22px;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        .brand-info h1 {
            font-size: 24px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.02em;
        }

        .brand-info p {
            font-size: 12px;
            color: #64748b;
            margin-top: 2px;
        }

        .meta-section {
            text-align: right;
        }

        .meta-section h2 {
            font-size: 16px;
            font-weight: 700;
            color: #2563eb;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .meta-section p {
            font-size: 12px;
            color: #64748b;
            margin-top: 4px;
        }

        /* ── Information Grid ── */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 30px;
            margin-bottom: 30px;
        }

        .info-block {
            background-color: #f8fafc;
            border: 1px solid #f1f5f9;
            border-radius: 12px;
            padding: 20px;
        }

        .info-block h3 {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            color: #64748b;
            letter-spacing: 0.05em;
            margin-bottom: 12px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 6px;
        }

        .info-row {
            margin-bottom: 6px;
            font-size: 13px;
        }

        .info-row strong {
            color: #0f172a;
            font-weight: 600;
        }

        .info-row span {
            color: #475569;
        }

        /* ── Detail Fields ── */
        .details-section {
            margin-bottom: 30px;
        }

        .details-title {
            font-size: 15px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .details-title i {
            color: #2563eb;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            overflow: hidden;
        }

        .details-table th {
            background-color: #f8fafc;
            padding: 12px 16px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            color: #64748b;
            border-bottom: 1px solid #e2e8f0;
            text-align: left;
        }

        .details-table td {
            padding: 14px 16px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 13px;
            color: #334155;
        }

        .details-table tr:last-child td {
            border-bottom: none;
        }

        .notes-area {
            background-color: #f8fafc;
            border-left: 4px solid #3b82f6;
            border-radius: 0 12px 12px 0;
            padding: 16px 20px;
            font-size: 13.5px;
            color: #334155;
            margin-bottom: 30px;
            white-space: pre-wrap;
        }

        /* ── Photos Attachments ── */
        .photos-section {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }

        .photos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-top: 12px;
        }

        .photo-card {
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 6px;
            background-color: #ffffff;
        }

        .photo-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 6px;
        }

        .photo-label {
            font-size: 11px;
            color: #64748b;
            text-align: center;
            margin-top: 6px;
            font-weight: 600;
        }

        /* ── Price Block ── */
        .cost-block {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 30px;
            page-break-inside: avoid;
        }

        .cost-table {
            width: 300px;
            border-collapse: collapse;
        }

        .cost-table td {
            padding: 10px 16px;
            font-size: 14px;
        }

        .cost-table td.label {
            text-align: right;
            color: #64748b;
            font-weight: 500;
        }

        .cost-table td.value {
            text-align: right;
            color: #0f172a;
            font-weight: 700;
        }

        .cost-table tr.total td {
            border-top: 2px solid #e2e8f0;
            font-size: 18px;
            padding-top: 14px;
        }

        .cost-table tr.total td.value {
            color: #22c55e;
        }

        /* ── Footer ── */
        .report-footer {
            border-top: 1px solid #e2e8f0;
            padding-top: 20px;
            text-align: center;
            color: #94a3b8;
            font-size: 11.5px;
            margin-top: 40px;
        }

        /* ── Print Actions (hidden on print) ── */
        .print-actions {
            max-width: 800px;
            margin: 0 auto 20px auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: 8px;
            font-size: 13.5px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
            border: 1px solid #e2e8f0;
        }

        .btn-back {
            background-color: #ffffff;
            color: #475569;
        }

        .btn-back:hover {
            background-color: #f1f5f9;
        }

        .btn-print {
            background-color: #2563eb;
            color: #ffffff;
            border-color: #2563eb;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);
        }

        .btn-print:hover {
            opacity: 0.9;
        }

        /* ── Media Print Customizations ── */
        @media print {
            body {
                padding: 0;
                background-color: #ffffff;
            }

            .report-container {
                border: none;
                padding: 0;
                max-width: 100%;
            }

            .print-actions {
                display: none;
            }

            /* Prevent page break inside cards and sections */
            .info-block, .details-table, .notes-area, .photos-section, .cost-block {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>

    <!-- Print Control Bar -->
    <div class="print-actions">
        <a href="{{ route('staff.job-records') }}" class="btn-action btn-back">
            <i class="fa-solid fa-arrow-left"></i> Back to Job Records
        </a>
        <button onclick="window.print()" class="btn-action btn-print">
            <i class="fa-solid fa-print"></i> Print or Save PDF
        </button>
    </div>

    <!-- Printable Report Box -->
    <div class="report-container">
        
        <!-- Header Section -->
        <header class="report-header">
            <div class="brand-section">
                <div class="brand-logo">
                    <i class="fa-solid fa-wrench"></i>
                </div>
                <div class="brand-info">
                    <h1>PLUMBFIX SERVICES</h1>
                    <p>Professional Residential & Commercial Plumbing</p>
                </div>
            </div>
            <div class="meta-section">
                <h2>Job Completion Report</h2>
                <p><strong>Report ID:</strong> #REC-{{ sprintf('%05d', $jobRecord->jobRecordID) }}</p>
                <p><strong>Date Generated:</strong> {{ date('d M Y, h:i A') }}</p>
            </div>
        </header>

        <!-- Address / Client Info Cards -->
        <div class="info-grid">
            
            <!-- Customer Card -->
            <div class="info-block">
                <h3>Customer Details</h3>
                <div class="info-row">
                    <strong>Name:</strong> <span>{{ $jobRecord->booking->customer->customerName ?? '—' }}</span>
                </div>
                <div class="info-row">
                    <strong>Email:</strong> <span>{{ $jobRecord->booking->customer->customerEmail ?? '—' }}</span>
                </div>
                <div class="info-row">
                    <strong>Phone:</strong> <span>{{ $jobRecord->booking->customer->customerPhoneNo ?? '—' }}</span>
                </div>
                <div class="info-row" style="margin-top: 8px;">
                    <strong>Service Location:</strong><br>
                    <span style="display:inline-block; margin-top:2px;">{{ $jobRecord->booking->customer->customerAddress ?? '—' }}</span>
                </div>
            </div>

            <!-- Plumber Card -->
            <div class="info-block">
                <h3>Service Details</h3>
                <div class="info-row">
                    <strong>Technician:</strong> <span>{{ $jobRecord->booking->staff->staffName ?? '—' }}</span>
                </div>
                <div class="info-row">
                    <strong>Specialization:</strong> <span>Plumbing Installer</span>
                </div>
                <div class="info-row">
                    <strong>Job Completion Date:</strong> <span>{{ $jobRecord->jobRecordCompletionDate ? $jobRecord->jobRecordCompletionDate->format('d M Y') : '—' }}</span>
                </div>
                <div class="info-row" style="margin-top: 8px;">
                    <strong>Reference Booking ID:</strong> <span>#BKG-{{ sprintf('%04d', $jobRecord->bookingID) }}</span>
                </div>
            </div>

        </div>

        <!-- Booking & Issue Description Table -->
        <div class="details-section">
            <h4 class="details-title"><i class="fa-solid fa-circle-info"></i> Service Assessment</h4>
            <table class="details-table">
                <thead>
                    <tr>
                        <th style="width: 30%;">Service Type</th>
                        <th style="width: 70%;">Problem Reported</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="font-weight: 600; color: #0f172a;">
                            {{ $jobRecord->booking->bookingType ?? 'Plumbing Repair' }}
                        </td>
                        <td>
                            <strong>{{ $jobRecord->booking->bookingProblem ?? 'General plumbing inspection' }}</strong>
                            @if($jobRecord->booking->bookingIssueDescription)
                                <div style="font-size: 12px; color: #64748b; margin-top: 4px;">
                                    {{ $jobRecord->booking->bookingIssueDescription }}
                                </div>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Completion Remarks / Notes -->
        <div class="details-section">
            <h4 class="details-title"><i class="fa-solid fa-list-check"></i> Job Completion Remarks</h4>
            <div class="notes-area">
                {{ $jobRecord->jobRecordNotes ?? 'Job completed successfully. System tested and verified functional. No secondary leaks or pressure issues observed.' }}
            </div>
        </div>

        <!-- Uploaded Images Section -->
        @if($jobRecord->jobRecordAttachments && count($jobRecord->jobRecordAttachments) > 0)
        <div class="photos-section">
            <h4 class="details-title"><i class="fa-solid fa-camera"></i> Before / After Verification Photos</h4>
            <div class="photos-grid">
                @foreach($jobRecord->jobRecordAttachments as $index => $attachment)
                <div class="photo-card">
                    <img src="{{ asset($attachment) }}" alt="Job Photo #{{ $index + 1 }}">
                    <div class="photo-label">Photo Reference #{{ $index + 1 }}</div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Cost Calculation Table -->
        <div class="cost-block">
            <table class="cost-table">
                <tbody>
                    <tr>
                        <td class="label">Subtotal Cost</td>
                        <td class="value">RM {{ number_format($jobRecord->jobRecordTotalCost, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="label">Tax / Service Fees (0%)</td>
                        <td class="value">RM 0.00</td>
                    </tr>
                    <tr class="total">
                        <td class="label">Total Paid</td>
                        <td class="value">RM {{ number_format($jobRecord->jobRecordTotalCost, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Footer -->
        <footer class="report-footer">
            <p>This document serves as an official proof of service completion. For support, reach out to help@plumbfix.com.</p>
            <p style="margin-top: 4px; font-weight: 500;">Thank you for choosing Plumbfix!</p>
        </footer>

    </div>

    <!-- Automatically open browser print utility -->
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                window.print();
            }, 600);
        });
    </script>
</body>
</html>
