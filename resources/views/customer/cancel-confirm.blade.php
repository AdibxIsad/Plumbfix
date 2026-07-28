<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Cancellation — Plumbfix</title>
    <meta name="description" content="Confirm cancellation and review refund policy.">
    
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

        :root {
            --bg-color: #f8fafc;
            --surface-color: rgba(255, 255, 255, 0.7);
            --surface-color-solid: #ffffff;
            --text-main: #475569;
            --text-muted: #94a3b8;
            --text-dark: #0f172a;
            --brand-color: #0d9488;
            --brand-light: #ccfbf1;
            --border-color: rgba(226, 232, 240, 0.8);
            --hover-color: rgba(241, 245, 249, 0.8);
            
            --accent-green: #10b981;
            --accent-green-bg: rgba(16, 185, 129, 0.1);
            --accent-orange: #f59e0b;
            --accent-orange-bg: rgba(245, 158, 11, 0.1);
            --accent-red: #ef4444;
            --accent-red-bg: rgba(239, 68, 68, 0.1);

            --glass-blur: 16px;
            --glass-border: 1px solid rgba(255, 255, 255, 0.6);
            --glass-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.04);
            
            --shadow-md: 0 10px 25px -5px rgba(13, 148, 136, 0.04), 0 8px 10px -6px rgba(13, 148, 136, 0.04);
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            overflow-x: hidden;
            position: relative;
        }

        /* Motion Background */
        .mesh-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: -2;
            overflow: hidden;
            background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 100%);
            pointer-events: none;
        }

        .mesh-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(140px);
            opacity: 0.45;
            animation: drift 25s infinite alternate ease-in-out;
        }

        .orb-1 {
            top: -10%;
            left: -10%;
            width: 45vw;
            height: 45vw;
            background: radial-gradient(circle, rgba(13, 148, 136, 0.18) 0%, rgba(13, 148, 136, 0) 70%);
        }

        .orb-2 {
            bottom: -10%;
            right: -10%;
            width: 50vw;
            height: 50vw;
            background: radial-gradient(circle, rgba(14, 165, 233, 0.22) 0%, rgba(14, 165, 233, 0) 70%);
            animation-delay: -7s;
        }

        @keyframes drift {
            0% { transform: translate(0, 0) scale(1) rotate(0deg); }
            50% { transform: translate(4%, 6%) scale(1.08) rotate(180deg); }
            100% { transform: translate(-2%, -4%) scale(0.96) rotate(360deg); }
        }

        .card {
            background: var(--surface-color);
            backdrop-filter: blur(var(--glass-blur));
            -webkit-backdrop-filter: blur(var(--glass-blur));
            border: var(--glass-border);
            border-radius: 24px;
            padding: 40px;
            max-width: 550px;
            width: 100%;
            box-shadow: var(--glass-shadow), var(--shadow-md);
            text-align: center;
        }

        .alert-icon {
            font-size: 54px;
            color: var(--accent-orange);
            margin-bottom: 20px;
            animation: pulse 2s infinite ease-in-out;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        h1 {
            font-size: 24px;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        p.subtitle {
            font-size: 14.5px;
            color: var(--text-muted);
            margin-bottom: 24px;
            font-weight: 500;
        }

        .details-box {
            background-color: var(--surface-color-solid);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 20px;
            text-align: left;
            margin-bottom: 24px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .details-row {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
        }

        .details-row span.label {
            color: var(--text-muted);
            font-weight: 500;
        }

        .details-row span.val {
            color: var(--text-dark);
            font-weight: 700;
        }

        .policy-box {
            border-radius: 16px;
            padding: 20px;
            text-align: left;
            margin-bottom: 24px;
            display: flex;
            gap: 14px;
            align-items: flex-start;
            border: 1px solid transparent;
        }

        .policy-box.eligible-full {
            background-color: var(--accent-green-bg);
            border-color: rgba(16, 185, 129, 0.2);
            color: #065f46;
        }

        .policy-box.eligible-partial {
            background-color: var(--accent-orange-bg);
            border-color: rgba(245, 158, 11, 0.2);
            color: #9a3412;
        }

        .policy-box.not-eligible {
            background-color: var(--accent-red-bg);
            border-color: rgba(239, 68, 68, 0.2);
            color: #991b1b;
        }

        .policy-box i {
            font-size: 22px;
            margin-top: 2px;
        }

        .policy-title {
            font-weight: 800;
            font-size: 15px;
            margin-bottom: 4px;
        }

        .policy-desc {
            font-size: 13.5px;
            line-height: 1.4;
            opacity: 0.9;
        }

        /* Form Controls */
        .form-group {
            text-align: left;
            margin-bottom: 20px;
        }

        label.form-label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            color: var(--text-muted);
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .form-input {
            width: 100%;
            background-color: var(--hover-color);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            padding: 12px 16px;
            color: var(--text-main);
            font-family: 'Outfit', sans-serif;
            font-size: 14.5px;
            transition: all 0.2s;
            outline: none;
        }

        .form-input:focus {
            border-color: var(--brand-color);
            background-color: var(--surface-color-solid);
            box-shadow: 0 0 0 3px rgba(13, 148, 136, 0.1);
        }

        textarea.form-input {
            resize: vertical;
            min-height: 90px;
        }

        .actions {
            display: flex;
            gap: 14px;
            margin-top: 8px;
        }

        .btn {
            flex: 1;
            padding: 14px;
            border-radius: 12px;
            font-family: 'Outfit', sans-serif;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.2s;
            border: none;
            text-align: center;
            text-decoration: none;
        }

        .btn-cancel {
            background-color: #ef4444;
            color: white;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
        }

        .btn-cancel:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .btn-back {
            background-color: var(--hover-color);
            border: 1px solid var(--border-color);
            color: var(--text-main);
        }

        .btn-back:hover {
            background-color: #e2e8f0;
            color: var(--text-dark);
            transform: translateY(-1px);
        }
    </style>
</head>
<body>

    <div class="mesh-bg">
        <div class="mesh-orb orb-1"></div>
        <div class="mesh-orb orb-2"></div>
    </div>

    <div class="card">
        <div class="alert-icon">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        
        <h1>Cancel Booking #{{ $booking->bookingID }}?</h1>
        <p class="subtitle">Please review our refund policy before confirming your cancellation.</p>

        <!-- Booking Details Summary -->
        <div class="details-box">
            <div class="details-row">
                <span class="label">Service Type</span>
                <span class="val">{{ $booking->bookingType }}</span>
            </div>
            <div class="details-row">
                <span class="label">Problem</span>
                <span class="val">{{ $booking->bookingProblem }}</span>
            </div>
            <div class="details-row">
                <span class="label">Scheduled For</span>
                <span class="val">{{ $booking->bookingDate->format('d M Y') }} at {{ \Carbon\Carbon::parse($booking->bookingTime)->format('h:i A') }}</span>
            </div>
            <div class="details-row">
                <span class="label">Deposit Paid</span>
                <span class="val" style="color: var(--accent-green);">RM {{ number_format($booking->bookingDepositAmount, 2) }}</span>
            </div>
        </div>

        <!-- Dynamic Refund Notice -->
        @php
            $refundInfo = $booking->calculateRefundEligibility();
        @endphp

        @if($refundInfo['eligible'])
            @if($refundInfo['amount'] == $booking->bookingDepositAmount)
                <!-- Full Refund -->
                <div class="policy-box eligible-full">
                    <i class="fa-solid fa-circle-check"></i>
                    <div>
                        <div class="policy-title">Eligible for Full Refund</div>
                        <div class="policy-desc">
                            You will receive a refund of <strong>RM {{ number_format($refundInfo['amount'], 2) }}</strong>. 
                            <br><small>{{ $refundInfo['reason'] }}</small>
                        </div>
                    </div>
                </div>
            @else
                <!-- Partial Refund -->
                <div class="policy-box eligible-partial">
                    <i class="fa-solid fa-circle-info"></i>
                    <div>
                        <div class="policy-title">Eligible for Partial Refund</div>
                        <div class="policy-desc">
                            You will receive a refund of <strong>RM {{ number_format($refundInfo['amount'], 2) }}</strong> (RM3.00 admin fee deducted).
                            <br><small>{{ $refundInfo['reason'] }}</small>
                        </div>
                    </div>
                </div>
            @endif
        @else
            <!-- No Refund -->
            <div class="policy-box not-eligible">
                <i class="fa-solid fa-circle-xmark"></i>
                <div>
                    <div class="policy-title">Non-Refundable Cancellation</div>
                    <div class="policy-desc">
                        No refund will be issued for this cancellation. The deposit of <strong>RM {{ number_format($booking->bookingDepositAmount, 2) }}</strong> is forfeited.
                        <br><small>{{ $refundInfo['reason'] }}</small>
                    </div>
                </div>
            </div>
        @endif

        <!-- Cancellation Form -->
        <form action="{{ route('customer.booking.delete', $booking->bookingID) }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="cancellation_reason" class="form-label">Why are you cancelling?</label>
                <select name="cancellation_reason" id="cancellation_reason" class="form-input" required>
                    <option value="" disabled selected>Select a reason...</option>
                    <option value="Change of plans / Schedule conflict">Change of plans / Schedule conflict</option>
                    <option value="Issue resolved on my own">Issue resolved on my own</option>
                    <option value="Accidental booking / Wrong details">Accidental booking / Wrong details</option>
                    <option value="Found another service provider">Found another service provider</option>
                    <option value="Other">Other (Please describe below)</option>
                </select>
            </div>

            <div class="form-group">
                <label for="cancellation_description" class="form-label">Additional Comments (Optional)</label>
                <textarea name="cancellation_description" id="cancellation_description" class="form-input" placeholder="Please provide any additional details..."></textarea>
            </div>

            <div class="actions">
                <a href="{{ route('customer.bookings') }}" class="btn btn-back">Keep Booking</a>
                <button type="submit" class="btn btn-cancel">Yes, Cancel Booking</button>
            </div>
        </form>
    </div>

</body>
</html>
