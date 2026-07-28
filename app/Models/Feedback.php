<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedbacks';
    protected $primaryKey = 'feedbackID';

    protected $fillable = [
        'customerID',
        'bookingID',
        'feedbackComments',
        'staffResponse',
        'feedbackRating',
        'feedbackAttachments',
    ];

    protected $casts = [
        'feedbackAttachments' => 'array',
    ];

    /**
     * Get the customer who gave this feedback.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customerID', 'customerID');
    }

    /**
     * Get the booking associated with this feedback.
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'bookingID', 'bookingID');
    }
}
