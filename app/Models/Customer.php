<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use Notifiable;

    /**
     * The table associated with this model.
     */
    protected $table = 'customers';

    /**
     * The primary key for the table.
     */
    protected $primaryKey = 'customerID';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'customerName',
        'customerEmail',
        'customerPhoneNo',
        'customerAddress',
        'customerPassword',
        'customerBankName',
        'customerBankAccountNo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'customerPassword',
        'remember_token',
    ];

    /**
     * Tell Laravel which column holds the password.
     */
    public function getAuthPasswordName(): string
    {
        return 'customerPassword';
    }

    /**
     * The attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'customerPassword' => 'hashed',
        ];
    }

    /**
     * Get bookings made by this customer.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'customer_id', 'customerID');
    }

    /**
     * Get feedbacks given by this customer.
     */
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'customer_id', 'customerID');
    }

    /**
     * Route mail notifications to the customerEmail column.
     */
    public function routeNotificationForMail($notification = null)
    {
        return $this->customerEmail;
    }
}
