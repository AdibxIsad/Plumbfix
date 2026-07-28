<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobRecord extends Model
{
    use HasFactory;

    protected $table = 'job_records';
    protected $primaryKey = 'jobRecordID';

    protected $fillable = [
        'bookingID',
        'staffID',
        'jobRecordCompletionDate',
        'jobRecordTotalCost',
        'jobRecordNotes',
        'jobRecordAttachments',
    ];

    protected function casts(): array
    {
        return [
            'jobRecordCompletionDate' => 'date',
            'jobRecordTotalCost'      => 'float',
            'jobRecordAttachments'    => 'array',
        ];
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'bookingID', 'bookingID');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staffID', 'staffID');
    }
}
