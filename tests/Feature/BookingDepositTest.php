<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Booking;
use App\Models\Staff;
use App\Models\PaymentReceipt;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BookingDepositTest extends TestCase
{
    use RefreshDatabase;

    public function test_booking_creation_succeeds_without_receipt_and_redirects_to_payment_page()
    {
        $customer = Customer::create([
            'customerName' => 'Test Customer',
            'customerEmail' => 'test@example.com',
            'customerPhoneNo' => '0123456789',
            'customerAddress' => '123 Test Street',
            'customerBankName' => 'Maybank',
            'customerBankAccountNo' => '164012345678',
            'customerPassword' => bcrypt('password123'),
        ]);

        $response = $this->actingAs($customer, 'customer')
            ->post(route('customer.booking.store'), [
                'bookingType' => 'Pipe Repair',
                'bookingProblem' => 'Leaky pipe under sink',
                'bookingDate' => now()->addDay()->toDateString(),
                'bookingTime' => '10:00:00',
            ]);

        $booking = Booking::first();
        $this->assertNotNull($booking);
        $response->assertRedirect(route('customer.bookings'));

        $this->assertDatabaseHas('bookings', [
            'customerID' => $customer->customerID,
            'bookingType' => 'Pipe Repair',
            'bookingProblem' => 'Leaky pipe under sink',
            'bookingDepositAmount' => 50.00,
            'paymentStatus' => 'Pending',
            'bookingDepositStatus' => 'pending',
            'bookingDepositReceipt' => null,
        ]);
    }

    public function test_customer_can_upload_image_receipt()
    {
        Storage::fake('public');
        \Illuminate\Support\Facades\Notification::fake();

        $customer = Customer::create([
            'customerName' => 'Test Customer',
            'customerEmail' => 'test@example.com',
            'customerPhoneNo' => '0123456789',
            'customerAddress' => '123 Test Street',
            'customerPassword' => bcrypt('password123'),
        ]);

        $booking = Booking::create([
            'customerID' => $customer->customerID,
            'bookingType' => 'Pipe Repair',
            'bookingProblem' => 'Leaky pipe under sink',
            'bookingDate' => now()->addDay()->toDateString(),
            'bookingTime' => '10:00:00',
            'bookingDepositAmount' => 50.00,
            'bookingStatus' => 'pending',
            'paymentStatus' => 'Pending',
            'bookingDepositStatus' => 'pending',
        ]);

        $file = UploadedFile::fake()->create('receipt.jpg', 100, 'image/jpeg');

        $response = $this->actingAs($customer, 'customer')
            ->post(route('customer.payment.upload', $booking->bookingID), [
                'payment_receipt' => $file,
                'payment_method' => 'DuitNow QR',
                'terms_accepted' => '1',
            ]);

        $response->assertRedirect(route('customer.bookings'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('bookings', [
            'bookingID' => $booking->bookingID,
            'paymentStatus' => 'Awaiting Verification',
            'bookingDepositStatus' => 'awaiting_verification',
            'paymentMethod' => 'DuitNow QR',
        ]);

        $this->assertDatabaseHas('payment_receipts', [
            'orderId' => $booking->bookingID,
            'status' => 'Awaiting Verification',
            'paymentMethod' => 'DuitNow QR',
        ]);

        $updatedBooking = Booking::first();
        $this->assertNotNull($updatedBooking->bookingDepositReceipt);
        $this->assertFileExists(public_path($updatedBooking->bookingDepositReceipt));

        // Clean up file
        if (file_exists(public_path($updatedBooking->bookingDepositReceipt))) {
            unlink(public_path($updatedBooking->bookingDepositReceipt));
        }
    }

    public function test_customer_can_upload_pdf_receipt()
    {
        Storage::fake('public');
        \Illuminate\Support\Facades\Notification::fake();

        $customer = Customer::create([
            'customerName' => 'Test Customer',
            'customerEmail' => 'test@example.com',
            'customerPhoneNo' => '0123456789',
            'customerAddress' => '123 Test Street',
            'customerPassword' => bcrypt('password123'),
        ]);

        $booking = Booking::create([
            'customerID' => $customer->customerID,
            'bookingType' => 'Pipe Repair',
            'bookingProblem' => 'Leaky pipe under sink',
            'bookingDate' => now()->addDay()->toDateString(),
            'bookingTime' => '10:00:00',
            'bookingDepositAmount' => 50.00,
            'bookingStatus' => 'pending',
            'paymentStatus' => 'Pending',
            'bookingDepositStatus' => 'pending',
        ]);

        $file = UploadedFile::fake()->create('receipt.pdf', 100, 'application/pdf');

        $response = $this->actingAs($customer, 'customer')
            ->post(route('customer.payment.upload', $booking->bookingID), [
                'payment_receipt' => $file,
                'payment_method' => 'Online Banking',
                'terms_accepted' => '1',
            ]);

        $response->assertRedirect(route('customer.bookings'));
        
        $this->assertDatabaseHas('bookings', [
            'bookingID' => $booking->bookingID,
            'paymentStatus' => 'Awaiting Verification',
            'bookingDepositStatus' => 'awaiting_verification',
            'paymentMethod' => 'Online Banking',
        ]);

        $updatedBooking = Booking::first();
        $this->assertStringEndsWith('.pdf', $updatedBooking->bookingDepositReceipt);
        $this->assertFileExists(public_path($updatedBooking->bookingDepositReceipt));

        // Clean up file
        if (file_exists(public_path($updatedBooking->bookingDepositReceipt))) {
            unlink(public_path($updatedBooking->bookingDepositReceipt));
        }
    }

    public function test_admin_can_approve_payment_which_updates_status_and_triggers_inventory_deduction()
    {
        \Illuminate\Support\Facades\Notification::fake();
        \Illuminate\Support\Facades\Mail::fake();

        $customer = Customer::create([
            'customerName' => 'Test Customer',
            'customerEmail' => 'test@example.com',
            'customerPhoneNo' => '0123456789',
            'customerAddress' => '123 Test Street',
            'customerPassword' => bcrypt('password123'),
        ]);

        $staff = Staff::create([
            'staffName' => 'Admin Staff',
            'staffEmail' => 'admin@gmail.com',
            'staffPhoneNo' => '0111111111',
            'staffPassword' => bcrypt('password123'),
            'adminID' => null, // Admin
        ]);

        $booking = Booking::create([
            'customerID' => $customer->customerID,
            'bookingType' => 'Pipe Repair',
            'bookingProblem' => 'Leaky pipe under sink',
            'bookingDate' => now()->addDay()->toDateString(),
            'bookingTime' => '10:00:00',
            'bookingDepositAmount' => 50.00,
            'bookingStatus' => 'pending',
            'paymentStatus' => 'Awaiting Verification',
            'bookingDepositStatus' => 'awaiting_verification',
            'bookingDepositReceipt' => 'uploads/receipts/fake_receipt.jpg',
            'paymentSubmittedAt' => now(),
        ]);

        PaymentReceipt::create([
            'orderId' => $booking->bookingID,
            'receiptPath' => 'uploads/receipts/fake_receipt.jpg',
            'uploadedAt' => now(),
            'status' => 'Awaiting Verification',
        ]);

        $response = $this->actingAs($staff, 'staff')
            ->post(route('staff.payments.approve', $booking->bookingID), [
                'staff_id' => $staff->staffID,
            ]);

        $response->assertRedirect(route('staff.payments.index'));

        $this->assertDatabaseHas('bookings', [
            'bookingID' => $booking->bookingID,
            'paymentStatus' => 'Paid',
            'bookingDepositStatus' => 'paid',
            'bookingStatus' => 'in_progress',
            'approvedBy' => $staff->staffID,
        ]);

        $this->assertDatabaseHas('payment_receipts', [
            'orderId' => $booking->bookingID,
            'status' => 'Paid',
        ]);
    }

    public function test_admin_can_approve_payment_and_assign_plumber_directly()
    {
        \Illuminate\Support\Facades\Notification::fake();
        \Illuminate\Support\Facades\Mail::fake();

        $customer = Customer::create([
            'customerName' => 'Test Customer',
            'customerEmail' => 'test@example.com',
            'customerPhoneNo' => '0123456789',
            'customerAddress' => '123 Test Street',
            'customerPassword' => bcrypt('password123'),
        ]);

        $adminStaff = Staff::create([
            'staffName' => 'Admin Staff',
            'staffEmail' => 'admin@gmail.com',
            'staffPhoneNo' => '0111111111',
            'staffPassword' => bcrypt('password123'),
            'adminID' => null, // Admin
        ]);

        $plumberStaff = Staff::create([
            'staffName' => 'Plumber Staff',
            'staffEmail' => 'plumber@example.com',
            'staffPhoneNo' => '0122222222',
            'staffPassword' => bcrypt('password123'),
            'adminID' => $adminStaff->staffID, // Plumber
            'status' => 'active',
        ]);

        $booking = Booking::create([
            'customerID' => $customer->customerID,
            'bookingType' => 'Pipe Repair',
            'bookingProblem' => 'Leaky pipe under sink',
            'bookingDate' => now()->addDay()->toDateString(),
            'bookingTime' => '10:00:00',
            'bookingDepositAmount' => 50.00,
            'bookingStatus' => 'pending',
            'paymentStatus' => 'Awaiting Verification',
            'bookingDepositStatus' => 'awaiting_verification',
            'bookingDepositReceipt' => 'uploads/receipts/fake_receipt.jpg',
            'paymentSubmittedAt' => now(),
        ]);

        PaymentReceipt::create([
            'orderId' => $booking->bookingID,
            'receiptPath' => 'uploads/receipts/fake_receipt.jpg',
            'uploadedAt' => now(),
            'status' => 'Awaiting Verification',
        ]);

        $response = $this->actingAs($adminStaff, 'staff')
            ->post(route('staff.payments.approve', $booking->bookingID), [
                'staff_id' => $plumberStaff->staffID,
            ]);

        $response->assertRedirect(route('staff.payments.index'));

        $this->assertDatabaseHas('bookings', [
            'bookingID' => $booking->bookingID,
            'paymentStatus' => 'Paid',
            'bookingDepositStatus' => 'paid',
            'bookingStatus' => 'in_progress', // In progress status
            'staffID' => $plumberStaff->staffID, // Assigned directly
            'approvedBy' => $adminStaff->staffID,
        ]);
    }

    public function test_admin_can_reject_payment_with_reason()
    {
        \Illuminate\Support\Facades\Notification::fake();

        $customer = Customer::create([
            'customerName' => 'Test Customer',
            'customerEmail' => 'test@example.com',
            'customerPhoneNo' => '0123456789',
            'customerAddress' => '123 Test Street',
            'customerPassword' => bcrypt('password123'),
        ]);

        $staff = Staff::create([
            'staffName' => 'Admin Staff',
            'staffEmail' => 'admin@gmail.com',
            'staffPhoneNo' => '0111111111',
            'staffPassword' => bcrypt('password123'),
            'adminID' => null, // Admin
        ]);

        $booking = Booking::create([
            'customerID' => $customer->customerID,
            'bookingType' => 'Pipe Repair',
            'bookingProblem' => 'Leaky pipe under sink',
            'bookingDate' => now()->addDay()->toDateString(),
            'bookingTime' => '10:00:00',
            'bookingDepositAmount' => 50.00,
            'bookingStatus' => 'pending',
            'paymentStatus' => 'Awaiting Verification',
            'bookingDepositStatus' => 'awaiting_verification',
            'bookingDepositReceipt' => 'uploads/receipts/fake_receipt.jpg',
            'paymentSubmittedAt' => now(),
        ]);

        PaymentReceipt::create([
            'orderId' => $booking->bookingID,
            'receiptPath' => 'uploads/receipts/fake_receipt.jpg',
            'uploadedAt' => now(),
            'status' => 'Awaiting Verification',
        ]);

        $response = $this->actingAs($staff, 'staff')
            ->post(route('staff.payments.reject', $booking->bookingID), [
                'rejection_reason' => 'Receipt is blur and unreadable.',
            ]);

        $response->assertRedirect(route('staff.payments.index'));

        $this->assertDatabaseHas('bookings', [
            'bookingID' => $booking->bookingID,
            'paymentStatus' => 'Rejected',
            'bookingDepositStatus' => 'rejected',
            'rejectionReason' => 'Receipt is blur and unreadable.',
        ]);

        $this->assertDatabaseHas('payment_receipts', [
            'orderId' => $booking->bookingID,
            'status' => 'Rejected',
            'remarks' => 'Receipt is blur and unreadable.',
        ]);
    }

    public function test_booking_create_redirects_if_profile_incomplete()
    {
        $customer = Customer::create([
            'customerName' => 'Incomplete Profile Customer',
            'customerEmail' => 'incomplete@example.com',
            'customerPhoneNo' => null,
            'customerAddress' => null,
            'customerPassword' => bcrypt('password123'),
        ]);

        $response = $this->actingAs($customer, 'customer')
            ->get(route('customer.booking.create'));

        $response->assertRedirect(route('customer.profile'));
        $response->assertSessionHasErrors('profile_required');
    }

    public function test_booking_store_redirects_if_profile_incomplete()
    {
        $customer = Customer::create([
            'customerName' => 'Incomplete Profile Customer',
            'customerEmail' => 'incomplete@example.com',
            'customerPhoneNo' => '0123456789',
            'customerAddress' => null, // missing address
            'customerPassword' => bcrypt('password123'),
        ]);

        $response = $this->actingAs($customer, 'customer')
            ->post(route('customer.booking.store'), [
                'bookingType' => 'Pipe Repair',
                'bookingProblem' => 'Leaky pipe under sink',
                'bookingDate' => now()->addDay()->toDateString(),
                'bookingTime' => '10:00:00',
            ]);

        $response->assertRedirect(route('customer.profile'));
        $response->assertSessionHasErrors('profile_required');
        $this->assertDatabaseEmpty('bookings');
    }

    public function test_booking_create_redirects_if_bank_details_missing()
    {
        $customer = Customer::create([
            'customerName' => 'Incomplete Profile Customer',
            'customerEmail' => 'incomplete@example.com',
            'customerPhoneNo' => '0123456789',
            'customerAddress' => '123 Test Street',
            'customerBankName' => null,
            'customerBankAccountNo' => null,
            'customerPassword' => bcrypt('password123'),
        ]);

        $response = $this->actingAs($customer, 'customer')
            ->get(route('customer.booking.create'));

        $response->assertRedirect(route('customer.profile'));
        $response->assertSessionHasErrors('profile_required');
    }

    public function test_unpaid_booking_does_not_conflict_with_new_booking_on_same_slot()
    {
        $customer1 = Customer::create([
            'customerName' => 'Customer One',
            'customerEmail' => 'c1@example.com',
            'customerPhoneNo' => '0123456789',
            'customerAddress' => '123 Test Street',
            'customerBankName' => 'Maybank',
            'customerBankAccountNo' => '164012345678',
            'customerPassword' => bcrypt('password123'),
        ]);

        $customer2 = Customer::create([
            'customerName' => 'Customer Two',
            'customerEmail' => 'c2@example.com',
            'customerPhoneNo' => '0198765432',
            'customerAddress' => '456 Test Street',
            'customerBankName' => 'CIMB',
            'customerBankAccountNo' => '123456789012',
            'customerPassword' => bcrypt('password123'),
        ]);

        $date = now()->addDay()->toDateString();
        $time = '10:00:00';

        // 1. Customer 1 stores a booking but does not pay
        $this->actingAs($customer1, 'customer')
            ->post(route('customer.booking.store'), [
                'bookingType' => 'Pipe Repair',
                'bookingProblem' => 'Leaky pipe under sink 1',
                'bookingDate' => $date,
                'bookingTime' => $time,
            ]);

        // 2. Customer 2 should be able to book the exact same slot without conflict since Customer 1 is unpaid
        $response = $this->actingAs($customer2, 'customer')
            ->post(route('customer.booking.store'), [
                'bookingType' => 'Drain Cleaning',
                'bookingProblem' => 'Clogged kitchen drain',
                'bookingDate' => $date,
                'bookingTime' => $time,
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('bookings', [
            'customerID' => $customer2->customerID,
            'bookingProblem' => 'Clogged kitchen drain',
            'paymentStatus' => 'Pending',
        ]);
    }

    public function test_payment_upload_fails_if_slot_already_taken_by_another_paid_booking()
    {
        $customer1 = Customer::create([
            'customerName' => 'Customer One',
            'customerEmail' => 'c1@example.com',
            'customerPhoneNo' => '0123456789',
            'customerAddress' => '123 Test Street',
            'customerBankName' => 'Maybank',
            'customerBankAccountNo' => '164012345678',
            'customerPassword' => bcrypt('password123'),
        ]);

        $customer2 = Customer::create([
            'customerName' => 'Customer Two',
            'customerEmail' => 'c2@example.com',
            'customerPhoneNo' => '0198765432',
            'customerAddress' => '456 Test Street',
            'customerBankName' => 'CIMB',
            'customerBankAccountNo' => '123456789012',
            'customerPassword' => bcrypt('password123'),
        ]);

        $date = now()->addDay()->toDateString();
        $time = '10:00:00';

        // Customer 1 booking
        $booking1 = Booking::create([
            'customerID' => $customer1->customerID,
            'bookingType' => 'Pipe Repair',
            'bookingProblem' => 'Leaky pipe 1',
            'bookingDate' => $date,
            'bookingTime' => $time,
            'bookingDepositAmount' => 50.00,
            'bookingStatus' => 'pending',
            'paymentStatus' => 'Pending',
        ]);

        // Customer 2 booking which is PAID
        Booking::create([
            'customerID' => $customer2->customerID,
            'bookingType' => 'Drain Cleaning',
            'bookingProblem' => 'Clogged pipe',
            'bookingDate' => $date,
            'bookingTime' => $time,
            'bookingDepositAmount' => 50.00,
            'bookingStatus' => 'pending',
            'paymentStatus' => 'Paid',
        ]);

        $file = UploadedFile::fake()->create('receipt.jpg', 100, 'image/jpeg');

        // Customer 1 tries to upload receipt but should fail with slot taken error
        $response = $this->actingAs($customer1, 'customer')
            ->post(route('customer.payment.upload', $booking1->bookingID), [
                'payment_receipt' => $file,
                'payment_method' => 'DuitNow QR',
                'terms_accepted' => '1',
            ]);

        $response->assertSessionHasErrors('payment_receipt');
        $this->assertDatabaseHas('bookings', [
            'bookingID' => $booking1->bookingID,
            'paymentStatus' => 'Pending', // unchanged
        ]);
    }
}
