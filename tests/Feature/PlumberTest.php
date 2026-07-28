<?php

namespace Tests\Feature;

use App\Models\Staff;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PlumberTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_plumbers_page()
    {
        $admin = Staff::create([
            'staffName' => 'Admin User',
            'staffEmail' => 'admin@example.com',
            'staffPhoneNo' => '+60 12-345 6789',
            'staffPassword' => Hash::make('secret123'),
            'adminID' => null, // indicates admin
        ]);

        $response = $this->actingAs($admin, 'staff')->get(route('staff.plumbers'));

        $response->assertStatus(200);
        $response->assertViewIs('staff.plumbers');
    }

    public function test_regular_staff_can_access_plumbers_page()
    {
        $admin = Staff::create([
            'staffName' => 'Admin User',
            'staffEmail' => 'admin@example.com',
            'staffPhoneNo' => '+60 12-345 6789',
            'staffPassword' => Hash::make('secret123'),
            'adminID' => null,
        ]);

        $plumber = Staff::create([
            'staffName' => 'Regular Plumber',
            'staffEmail' => 'plumber@example.com',
            'staffPhoneNo' => '+60 13-987 6543',
            'staffPassword' => Hash::make('secret123'),
            'adminID' => $admin->staffID, // regular staff
        ]);

        $response = $this->actingAs($plumber, 'staff')->get(route('staff.plumbers'));

        $response->assertStatus(200);
    }

    public function test_regular_staff_cannot_create_plumber()
    {
        $admin = Staff::create([
            'staffName' => 'Admin User',
            'staffEmail' => 'admin@example.com',
            'staffPhoneNo' => '+60 12-345 6789',
            'staffPassword' => Hash::make('secret123'),
            'adminID' => null,
        ]);

        $plumber = Staff::create([
            'staffName' => 'Regular Plumber',
            'staffEmail' => 'plumber@example.com',
            'staffPhoneNo' => '+60 13-987 6543',
            'staffPassword' => Hash::make('secret123'),
            'adminID' => $admin->staffID, // regular staff
        ]);

        $plumberData = [
            'staffName' => 'Unauthorized Plumber',
            'staffEmail' => 'unauth@example.com',
            'staffPhoneNo' => '0145555555',
            'status' => 'active',
            'staffPassword' => 'password123',
        ];

        $response = $this->actingAs($plumber, 'staff')->post(route('staff.plumbers.store'), $plumberData);

        $response->assertStatus(403);
    }

    public function test_admin_can_create_plumber()
    {
        $admin = Staff::create([
            'staffName' => 'Admin User',
            'staffEmail' => 'admin@example.com',
            'staffPhoneNo' => '+60 12-345 6789',
            'staffPassword' => Hash::make('secret123'),
            'adminID' => null,
        ]);

        $plumberData = [
            'staffName' => 'New Plumber',
            'staffEmail' => 'newplumber@example.com',
            'staffPhoneNo' => '0145555555',
            'status' => 'active',
            'staffPassword' => 'password123',
        ];

        $response = $this->actingAs($admin, 'staff')->post(route('staff.plumbers.store'), $plumberData);

        $response->assertRedirect(route('staff.plumbers'));
        $this->assertDatabaseHas('staffs', [
            'staffName' => 'New Plumber',
            'staffEmail' => 'newplumber@example.com',
            'staffPhoneNo' => '+60 14-555 5555',
            'status' => 'active',
        ]);
    }

    public function test_admin_can_update_plumber()
    {
        $admin = Staff::create([
            'staffName' => 'Admin User',
            'staffEmail' => 'admin@example.com',
            'staffPhoneNo' => '+60 12-345 6789',
            'staffPassword' => Hash::make('secret123'),
            'adminID' => null,
        ]);

        $plumber = Staff::create([
            'staffName' => 'Old Name',
            'staffEmail' => 'oldemail@example.com',
            'staffPhoneNo' => '+60 19-999 9999',
            'status' => 'active',
            'staffPassword' => Hash::make('password123'),
            'adminID' => $admin->staffID,
        ]);

        $updateData = [
            'staffName' => 'Updated Name',
            'staffEmail' => 'updatedemail@example.com',
            'staffPhoneNo' => '0188888888',
            'status' => 'inactive',
        ];

        $response = $this->actingAs($admin, 'staff')->put(route('staff.plumbers.update', $plumber->staffID), $updateData);

        $response->assertRedirect(route('staff.plumbers'));
        $this->assertDatabaseHas('staffs', [
            'staffID' => $plumber->staffID,
            'staffName' => 'Updated Name',
            'staffEmail' => 'updatedemail@example.com',
            'staffPhoneNo' => '+60 18-888 8888',
            'status' => 'inactive',
        ]);
    }

    public function test_admin_can_delete_plumber()
    {
        $admin = Staff::create([
            'staffName' => 'Admin User',
            'staffEmail' => 'admin@example.com',
            'staffPhoneNo' => '+60 12-345 6789',
            'staffPassword' => Hash::make('secret123'),
            'adminID' => null,
        ]);

        $plumber = Staff::create([
            'staffName' => 'Plumber to Delete',
            'staffEmail' => 'delete_me@example.com',
            'staffPhoneNo' => '+60 11-1111 1111',
            'status' => 'active',
            'staffPassword' => Hash::make('password123'),
            'adminID' => $admin->staffID,
        ]);

        $response = $this->actingAs($admin, 'staff')->delete(route('staff.plumbers.destroy', $plumber->staffID));

        $response->assertRedirect(route('staff.plumbers'));
        $this->assertDatabaseMissing('staffs', [
            'staffID' => $plumber->staffID,
        ]);
    }
}
