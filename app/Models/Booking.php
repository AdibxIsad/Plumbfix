<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';
    protected $primaryKey = 'bookingID';

    protected $fillable = [
        'customerID',
        'staffID',
        'bookingType',
        'bookingProblem',
        'bookingIssueDescription',
        'bookingDate',
        'bookingTime',
        'bookingStatus',
        'bookingAttachment',
        'bookingDepositReceipt',
        'bookingDepositAmount',
        'bookingDepositStatus',
        'paymentStatus',
        'paymentSubmittedAt',
        'paymentApprovedAt',
        'paymentRejectedAt',
        'approvedBy',
        'rejectionReason',
        'paymentMethod',
        'cancelled_at',
        'cancellation_reason',
        'cancellation_description',
        'refund_status',
        'refund_amount',
        'refund_completed_at',
        'refund_receipt_path',
        'refund_remarks',
    ];

    protected $casts = [
        'bookingDate' => 'datetime',
        'paymentSubmittedAt' => 'datetime',
        'paymentApprovedAt' => 'datetime',
        'paymentRejectedAt' => 'datetime',
        'cancelled_at' => 'datetime',
        'refund_completed_at' => 'datetime',
    ];

    /**
     * Get the payment receipts for this booking.
     */
    public function paymentReceipts()
    {
        return $this->hasMany(PaymentReceipt::class, 'orderId', 'bookingID');
    }

    /**
     * Get the customer who made this booking.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customerID', 'customerID');
    }

    /**
     * Get the staff assigned to this booking.
     */
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staffID', 'staffID');
    }

    /**
     * Get the staff/admin who approved the payment for this booking.
     */
    public function approver()
    {
        return $this->belongsTo(Staff::class, 'approvedBy', 'staffID');
    }

    /**
     * Get the feedback for this booking.
     */
    public function feedback()
    {
        return $this->hasOne(Feedback::class, 'bookingID', 'bookingID');
    }

    /**
     * Get the job record associated with this booking.
     */
    public function jobRecord()
    {
        return $this->hasOne(JobRecord::class, 'bookingID', 'bookingID');
    }

    /**
     * Get the chat messages for this booking.
     */
    public function chatMessages()
    {
        return $this->hasMany(ChatMessage::class, 'bookingID', 'bookingID')->orderBy('created_at', 'asc');
    }


    /**
     * Get the compatible emoji/icon for the booking type.
     */
    public function getServiceIconAttribute(): string
    {
        $icons = [
            'Pipe Repair' => '🔩',
            'Drain Cleaning' => '🚿',
            'Leak Detection' => '💧',
            'Water Heater' => '🔥',
            'Toilet Repair' => '🚽',
            'Tap & Faucet' => '🚰',
            'Water Tank' => '🏗️',
            'General Inspection' => '🔍',
        ];

        return $icons[$this->bookingType] ?? '🔧';
    }

    /**
     * Get the compatible FontAwesome class for the booking type.
     */
    public function getServiceFaIconAttribute(): string
    {
        $icons = [
            'Pipe Repair' => 'fa-screwdriver-wrench',
            'Drain Cleaning' => 'fa-shower',
            'Leak Detection' => 'fa-droplet',
            'Water Heater' => 'fa-fire',
            'Toilet Repair' => 'fa-toilet',
            'Tap & Faucet' => 'fa-faucet',
            'Water Tank' => 'fa-database',
            'General Inspection' => 'fa-magnifying-glass',
        ];

        return $icons[$this->bookingType] ?? 'fa-wrench';
    }

    /**
     * Calculate refund eligibility and amount.
     * Rules:
     * - Grace Period: If cancelled within 30 minutes of creation -> Full Refund.
     * - Notice Period >= 48 hours: Full Refund (100% of deposit).
     * - Notice Period >= 24 hours and < 48 hours: Partial Refund (Deposit minus RM3.00 admin fee).
     * - Notice Period < 24 hours: No Refund.
     */
    public function calculateRefundEligibility(): array
    {
        $createdAt = $this->created_at;
        
        // Ensure bookingDate is parsed correctly
        $dateStr = $this->bookingDate instanceof \Carbon\Carbon 
            ? $this->bookingDate->format('Y-m-d') 
            : \Carbon\Carbon::parse($this->bookingDate)->format('Y-m-d');
            
        $bookingDateTime = \Carbon\Carbon::parse($dateStr . ' ' . $this->bookingTime);
        $now = now();

        // If deposit was notPaid/Approved, not eligible
        if ($this->paymentStatus !== 'Paid') {
            return [
                'eligible' => false,
                'amount' => 0.00,
                'reason' => 'Deposit payment was not completed or verified.'
            ];
        }

        // 1. Grace Period: 30 minutes since creation
        if ($now->diffInMinutes($createdAt) <= 30) {
            return [
                'eligible' => true,
                'amount' => $this->bookingDepositAmount,
                'reason' => 'Cancelled within 30 minutes of booking (Grace Period).'
            ];
        }

        // 2. Notice period calculation
        $hoursToService = $now->diffInHours($bookingDateTime, false);

        if ($hoursToService >= 48) {
            return [
                'eligible' => true,
                'amount' => $this->bookingDepositAmount,
                'reason' => 'Cancelled 48 hours or more before scheduled service.'
            ];
        } elseif ($hoursToService >= 24) {
            $refundAmount = max(0, $this->bookingDepositAmount - 3.00);
            return [
                'eligible' => true,
                'amount' => $refundAmount,
                'reason' => 'Cancelled 24 to 48 hours before scheduled service (Deducted RM3.00 gateway fee).'
            ];
        } else {
            return [
                'eligible' => false,
                'amount' => 0.00,
                'reason' => 'Cancelled less than 24 hours before scheduled service.'
            ];
        }
    }
}
