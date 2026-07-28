<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Staff;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with initial accounts.
     */
    public function run(): void
    {
        // Create Admin Staff account
        Staff::updateOrCreate(
            ['staffEmail' => 'admin@gmail.com'],
            [
                'staffName' => 'System Admin',
                'staffPhoneNo' => '0123456789',
                'staffPassword' => Hash::make('admin123'),
                'adminID' => null,
                'status' => 'Active',
            ]
        );

        // Create Regular Staff / Plumber account
        Staff::updateOrCreate(
            ['staffEmail' => 'staff@gmail.com'],
            [
                'staffName' => 'John Plumber',
                'staffPhoneNo' => '0198765432',
                'staffPassword' => Hash::make('staff123'),
                'adminID' => 1,
                'specialization' => 'Pipe Repair & Fitting',
                'status' => 'Active',
            ]
        );

        // Create Demo Customer account
        Customer::updateOrCreate(
            ['customerEmail' => 'customer@gmail.com'],
            [
                'customerName' => 'Demo Customer',
                'customerPhoneNo' => '0112345678',
                'customerAddress' => '123 Jalan Ampang, Kuala Lumpur',
                'customerPassword' => Hash::make('customer123'),
            ]
        );
    }
}
