<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    protected $table = 'chat_messages';
    protected $primaryKey = 'chatMessageID';

    protected $fillable = [
        'bookingID',
        'sender_type',
        'sender_id',
        'message',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'bookingID', 'bookingID');
    }

    public function sender()
    {
        if ($this->sender_type === 'customer') {
            return $this->belongsTo(Customer::class, 'sender_id', 'customerID');
        }
        return $this->belongsTo(Staff::class, 'sender_id', 'staffID');
    }
}
