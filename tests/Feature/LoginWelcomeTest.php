<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Staff;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginWelcomeTest extends TestCase
{
    use RefreshDatabase;

    private function createCustomer()
    {
        return Customer::create([
            'customerName' => 'Alice Customer',
            'customerEmail' => 'alice@example.com',
            'customerPhoneNo' => '0123456789',
            'customerAddress' => '123 Test Street',
            'customerPassword' => Hash::make('password123'),
        ]);
    }

    private function createStaff($email = 'staff@example.com', $isAdmin = false)
    {
        if ($isAdmin) {
            return Staff::create([
                'staffName' => 'Admin User',
                'staffEmail' => $email,
                'staffPhoneNo' => '+60 12-345 6789',
                'staffPassword' => Hash::make('secret123'),
                'adminID' => null, // admin has no supervisor/adminID or staffEmail admin@gmail.com
            ]);
        }

        // To make a regular staff, we link them to an admin
        $admin = Staff::whereNull('adminID')->first();
        if (!$admin) {
            $admin = Staff::create([
                'staffName' => 'System Admin',
                'staffEmail' => 'admin@gmail.com',
                'staffPhoneNo' => '+60 12-000 0000',
                'staffPassword' => Hash::make('secret123'),
                'adminID' => null,
            ]);
        }

        return Staff::create([
            'staffName' => 'Regular Staff',
            'staffEmail' => $email,
            'staffPhoneNo' => '+60 13-987 6543',
            'staffPassword' => Hash::make('secret123'),
            'adminID' => $admin->staffID,
        ]);
    }

    public function test_customer_login_redirects_with_welcome_message()
    {
        $customer = $this->createCustomer();

        $response = $this->post(route('login.post'), [
            'email' => 'alice@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
        $response->assertSessionHas('welcome', 'Welcome back, Alice Customer! You have successfully logged into your account.');
    }

    public function test_admin_login_redirects_with_welcome_message()
    {
        $admin = $this->createStaff('admin@gmail.com', true);

        $response = $this->post(route('login.post'), [
            'email' => 'admin@gmail.com',
            'password' => 'secret123',
        ]);

        $response->assertRedirect(route('staff.dashboard'));
        $response->assertSessionHas('welcome', 'Welcome back, Administrator Admin User! You have successfully logged into your account.');
    }

    public function test_staff_login_redirects_with_welcome_message()
    {
        $staff = $this->createStaff('staff@example.com', false);

        $response = $this->post(route('login.post'), [
            'email' => 'staff@example.com',
            'password' => 'secret123',
        ]);

        $response->assertRedirect(route('staff.dashboard'));
        $response->assertSessionHas('welcome', 'Welcome back, Staff Regular Staff! You have successfully logged into your account.');
    }

    public function test_customer_registration_redirects_with_welcome_message()
    {
        $response = $this->post(route('register.post'), [
            'name' => 'Bob Builder',
            'email' => 'bob@example.com',
            'phone' => '01122334455',
            'address' => '456 Construction Rd',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
        $response->assertSessionHas('welcome', 'Welcome, Bob Builder! Your account has been created and you have successfully logged in.');
    }
}
