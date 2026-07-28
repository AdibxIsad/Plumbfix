<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Staff extends Authenticatable
{
    use Notifiable;

    /**
     * The table associated with this model.
     */
    protected $table = 'staffs';

    /**
     * The primary key for the table.
     */
    protected $primaryKey = 'staffID';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'staffName',
        'staffEmail',
        'staffPhoneNo',
        'staffPassword',
        'specialization',
        'status',
        'avatar',
        'adminID',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'staffPassword',
        'remember_token',
    ];

    /**
     * Tell Laravel which column holds the password.
     */
    public function getAuthPasswordName(): string
    {
        return 'staffPassword';
    }

    /**
     * The attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'staffPassword' => 'hashed',
        ];
    }

    /**
     * Check if the staff member is an administrator.
     */
    public function isAdmin(): bool
    {
        return is_null($this->adminID) || $this->staffEmail === 'admin@gmail.com';
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'staffID', 'staffID');
    }

    public function jobRecords()
    {
        return $this->hasMany(JobRecord::class, 'staffID', 'staffID');
    }

    /**
     * Route mail notifications to the staffEmail column.
     */
    public function routeNotificationForMail($notification = null)
    {
        return $this->staffEmail;
    }
}
