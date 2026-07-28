<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'generated_by',
        'title',
        'report_type',
        'date_from',
        'date_to',
        'content',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date_from' => 'date',
            'date_to' => 'date',
        ];
    }

    /**
     * Get the staff who generated this report.
     */
    public function generatedBy()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }
}
