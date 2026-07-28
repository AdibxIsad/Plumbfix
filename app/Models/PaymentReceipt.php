<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentReceipt extends Model
{
    use HasFactory;

    protected $table = 'payment_receipts';

    protected $fillable = [
        'orderId',
        'receiptPath',
        'uploadedAt',
        'status',
        'remarks',
        'paymentMethod',
    ];

    protected function casts(): array
    {
        return [
            'uploadedAt' => 'datetime',
        ];
    }

    /**
     * Get the booking associated with this receipt.
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'orderId', 'bookingID');
    }
}
