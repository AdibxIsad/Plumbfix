<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Receipt #BKG-{{ $booking->bookingID }} — Plumbfix</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1e293b;
            line-height: 1.4;
            font-size: 13px;
            margin: 0;
            padding: 10px;
        }
        .report-header {
            border-bottom: 2px solid #10b981;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
        }
        .brand-title {
            font-size: 22px;
            font-weight: bold;
            color: #0f172a;
        }
        .brand-sub {
            font-size: 11px;
            color: #64748b;
        }
        .meta-section {
            text-align: right;
        }
        .meta-section h2 {
            font-size: 16px;
            color: #10b981;
            margin: 0 0 5px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .info-col {
            width: 50%;
            vertical-align: top;
        }
        .info-block {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 15px;
            margin-right: 10px;
        }
        .info-block-right {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 15px;
            margin-left: 10px;
        }
        .info-block h3, .info-block-right h3 {
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            color: #64748b;
            border-bottom: 1px solid #cbd5e1;
            padding-bottom: 4px;
            margin: 0 0 10px 0;
        }
        .info-row {
            margin-bottom: 5px;
        }
        .info-row strong {
            color: #0f172a;
        }
        .info-row span {
            color: #475569;
        }
        .details-title {
            font-size: 14px;
            font-weight: bold;
            color: #0f172a;
            margin: 15px 0 8px 0;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border: 1px solid #e2e8f0;
        }
        .details-table th {
            background-color: #f8fafc;
            padding: 10px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            color: #64748b;
            border-bottom: 1px solid #cbd5e1;
            text-align: left;
        }
        .details-table td {
            padding: 12px 10px;
            border-bottom: 1px solid #e2e8f0;
            color: #334155;
        }
        .notes-area {
            background-color: #ecfdf5;
            border-left: 4px solid #10b981;
            padding: 12px 15px;
            color: #065f46;
            margin-bottom: 20px;
            font-size: 12.5px;
            font-weight: bold;
        }
        .cost-section {
            width: 100%;
            margin-top: 15px;
        }
        .cost-table {
            width: 280px;
            float: right;
            border-collapse: collapse;
        }
        .cost-table td {
            padding: 8px 10px;
        }
        .cost-table td.label {
            text-align: right;
            color: #64748b;
            font-weight: 500;
        }
        .cost-table td.value {
            text-align: right;
            color: #0f172a;
            font-weight: bold;
        }
        .cost-table tr.total td {
            border-top: 1px solid #cbd5e1;
            font-size: 16px;
            padding-top: 10px;
        }
        .cost-table tr.total td.value {
            color: #10b981;
        }
        .clear {
            clear: both;
        }
        .report-footer {
            border-top: 1px solid #e2e8f0;
            padding-top: 15px;
            text-align: center;
            color: #94a3b8;
            font-size: 10.5px;
            margin-top: 40px;
        }
    </style>
</head>
<body>

    <!-- Header Section -->
    <div class="report-header">
        <table class="header-table">
            <tr>
                <td>
                    <div class="brand-title">PLUMBFIX SERVICES</div>
                    <div class="brand-sub">Professional Residential & Commercial Plumbing</div>
                </td>
                <td class="meta-section">
                    <h2>Official Receipt</h2>
                    <div><strong>Receipt Reference:</strong> #REC-BKG-{{ $booking->bookingID }}</div>
                    <div style="font-size: 11px; color:#64748b; margin-top:3px;">
                        Date Generated: {{ \Carbon\Carbon::now('Asia/Kuala_Lumpur')->format('d M Y, h:i A') }} (MYT)
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Client & Receipt Info Grid -->
    <table class="info-table">
        <tr>
            <td class="info-col">
                <div class="info-block">
                    <h3>Customer Details</h3>
                    <div class="info-row">
                        <strong>Name:</strong> <span>{{ $booking->customer->customerName ?? '—' }}</span>
                    </div>
                    <div class="info-row">
                        <strong>Email:</strong> <span>{{ $booking->customer->customerEmail ?? '—' }}</span>
                    </div>
                    <div class="info-row">
                        <strong>Phone:</strong> <span>{{ $booking->customer->customerPhoneNo ?? '—' }}</span>
                    </div>
                    <div class="info-row" style="margin-top: 5px;">
                        <strong>Address:</strong><br>
                        <span>{{ $booking->customer->customerAddress ?? '—' }}</span>
                    </div>
                </div>
            </td>
            <td class="info-col">
                <div class="info-block-right">
                    <h3>Payment Details</h3>
                    <div class="info-row">
                        <strong>Status:</strong> <span style="color: #10b981; font-weight: bold;">PAID</span>
                    </div>
                    <div class="info-row">
                        <strong>Payment Submitted:</strong> <span>{{ $booking->paymentSubmittedAt ? $booking->paymentSubmittedAt->timezone('Asia/Kuala_Lumpur')->format('d M Y, h:i A') : '—' }}</span>
                    </div>
                    <div class="info-row">
                        <strong>Payment Verified:</strong> <span>{{ $booking->paymentApprovedAt ? $booking->paymentApprovedAt->timezone('Asia/Kuala_Lumpur')->format('d M Y, h:i A') : '—' }}</span>
                    </div>
                    <div class="info-row">
                        <strong>Verified By:</strong> <span>{{ $booking->approvedBy ? (\App\Models\Staff::find($booking->approvedBy)->staffName ?? 'Admin') : 'Admin' }}</span>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <!-- Service Details -->
    <div class="details-title">Scheduled Service Information</div>
    <table class="details-table">
        <thead>
            <tr>
                <th style="width: 30%;">Service Type</th>
                <th style="width: 70%;">Problem Description</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="font-weight: bold; color: #0f172a;">
                    {{ $booking->bookingType ?? 'Plumbing Repair' }}
                </td>
                <td>
                    <strong>{{ $booking->bookingProblem ?? 'General plumbing inspection' }}</strong>
                    @if($booking->bookingIssueDescription)
                        <div style="font-size: 11px; color: #64748b; margin-top: 3px;">
                            {{ $booking->bookingIssueDescription }}
                        </div>
                    @endif
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Confirmation Area -->
    <div class="notes-area">
        STATUS: Booking Deposit Verified. This document serves as a receipt and confirmation of your booking deposit payment. Your booking status is now "Processing".
    </div>

    <!-- Cost Section -->
    <div class="cost-section">
        <table class="cost-table">
            <tr>
                <td class="label">Booking Deposit Amount</td>
                <td class="value">RM {{ number_format($booking->bookingDepositAmount ?? 50.00, 2) }}</td>
            </tr>
            <tr class="total">
                <td class="label">Total Amount Paid</td>
                <td class="value">RM {{ number_format($booking->bookingDepositAmount ?? 50.00, 2) }}</td>
            </tr>
        </table>
        <div class="clear"></div>
    </div>

    <!-- Footer -->
    <div class="report-footer">
        <p>This is a computer-generated document and requires no signature. For any support inquiries, contact billing@plumbfix.com.</p>
        <p style="margin-top: 4px; font-weight: bold; color:#10b981;">Thank you for your payment!</p>
    </div>

</body>
</html>
