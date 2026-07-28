<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Booking;
use App\Models\Staff;
use App\Models\JobRecord;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class PlumbfixImprovementsTest extends TestCase
{
    use RefreshDatabase;

    private function createCustomer($email = 'customer@example.com')
    {
        return Customer::create([
            'customerName' => 'Test Customer',
            'customerEmail' => $email,
            'customerPhoneNo' => '0123456789',
            'customerAddress' => '123 Test Street',
            'customerPassword' => Hash::make('password123'),
        ]);
    }

    private function createStaff($email = 'plumber@example.com')
    {
        $admin = Staff::create([
            'staffName' => 'Admin User',
            'staffEmail' => 'admin@example.com',
            'staffPhoneNo' => '+60 12-345 6789',
            'staffPassword' => Hash::make('secret123'),
            'adminID' => null, // admin
        ]);

        return Staff::create([
            'staffName' => 'Regular Plumber',
            'staffEmail' => $email,
            'staffPhoneNo' => '+60 13-987 6543',
            'staffPassword' => Hash::make('secret123'),
            'adminID' => $admin->staffID, // regular staff
        ]);
    }

    private function createBooking($customer, $staff = null, $status = 'pending')
    {
        return Booking::create([
            'customerID' => $customer->customerID,
            'staffID' => $staff ? $staff->staffID : null,
            'bookingType' => 'Pipe Repair',
            'bookingProblem' => 'Leaking faucet',
            'bookingDate' => now()->toDateString(),
            'bookingTime' => '10:00:00',
            'bookingStatus' => $status,
            'bookingDepositAmount' => 50.00,
            'bookingDepositStatus' => 'paid',
            'bookingDepositReceipt' => 'uploads/receipts/fake.jpg',
        ]);
    }

    public function test_booking_status_update_state_machine_validations()
    {
        $customer = $this->createCustomer();
        $staff = $this->createStaff();
        $booking = $this->createBooking($customer, $staff, 'pending');

        // Transition: pending -> confirmed (Valid)
        $response = $this->actingAs($staff, 'staff')
            ->post(route('staff.booking.status', $booking->bookingID), [
                'bookingStatus' => 'confirmed'
            ]);
        $response->assertRedirect(route('staff.bookings'));
        $this->assertEquals('confirmed', $booking->fresh()->bookingStatus);

        // Transition: confirmed -> completed (Invalid - must go to in_progress first)
        $response = $this->actingAs($staff, 'staff')
            ->post(route('staff.booking.status', $booking->bookingID), [
                'bookingStatus' => 'completed'
            ]);
        $response->assertSessionHasErrors('bookingStatus');
        $this->assertEquals('confirmed', $booking->fresh()->bookingStatus);

        // Transition: confirmed -> in_progress (Valid)
        $response = $this->actingAs($staff, 'staff')
            ->post(route('staff.booking.status', $booking->bookingID), [
                'bookingStatus' => 'in_progress'
            ]);
        $response->assertRedirect(route('staff.bookings'));
        $this->assertEquals('in_progress', $booking->fresh()->bookingStatus);
    }

    public function test_route_notification_for_mail_works_on_custom_columns()
    {
        $customer = $this->createCustomer('cust@customemail.com');
        $staff = $this->createStaff('stf@customemail.com');

        $this->assertEquals('cust@customemail.com', $customer->routeNotificationForMail());
        $this->assertEquals('stf@customemail.com', $staff->routeNotificationForMail());
    }

    public function test_save_job_record_and_send_email_invoice()
    {
        Mail::fake();
        Notification::fake();

        $customer = $this->createCustomer();
        $staff = $this->createStaff();
        // Set the booking to completed so a job record can be created
        $booking = $this->createBooking($customer, $staff, 'completed');

        $response = $this->actingAs($staff, 'staff')
            ->post(route('staff.job-record.store'), [
                'bookingID' => $booking->bookingID,
                'jobRecordCompletionDate' => now()->toDateString(),
                'jobRecordTotalCost' => 150.00,
                'jobRecordNotes' => 'Replaced washers and resealed pipe.',
                'send_invoice_email' => '1',
            ]);

        $response->assertRedirect(route('staff.job-records'));
        $response->assertSessionHas('success');

        // Check Job Record was saved
        $this->assertDatabaseHas('job_records', [
            'bookingID' => $booking->bookingID,
            'jobRecordTotalCost' => 150.00,
        ]);

        // Check invoice email was sent
        Mail::assertSent(function (\App\Mail\ActivityNotificationMail $mail) use ($customer) {
            return $mail->hasTo($customer->customerEmail);
        });

        // Check recent activity notification was sent
        Notification::assertSentTo($customer, \App\Notifications\RecentActivityNotification::class);
    }

    public function test_deposit_payment_request_sends_email_to_customer_email()
    {
        Notification::fake();

        $customer = $this->createCustomer('customer_deposit@example.com');
        $staff = $this->createStaff();
        $booking = $this->createBooking($customer, null, 'pending');

        $response = $this->actingAs($staff, 'staff')
            ->post(route('staff.booking.accept', $booking->bookingID));

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('staff.bookings'));

        Notification::assertSentTo(
            $customer,
            \App\Notifications\RecentActivityNotification::class,
            function ($notification, $channels, $notifiable) use ($customer) {
                $mailable = $notification->toMail($notifiable);
                return in_array('mail', $channels) &&
                       $mailable->hasTo('customer_deposit@example.com') &&
                       $mailable->subjectLine === 'Deposit Payment Request — PlumbFix';
            }
        );
    }

    public function test_feedback_store_requires_completed_unreviewed_booking()
    {
        Notification::fake();

        $customer = $this->createCustomer('reviewer@example.com');
        $staff = $this->createStaff();
        
        $pendingBooking = $this->createBooking($customer, $staff, 'pending');
        $completedBooking = $this->createBooking($customer, $staff, 'completed');

        // 1. Try to submit feedback without bookingID (should fail validation)
        $response = $this->actingAs($customer, 'customer')
            ->post(route('customer.feedback.store'), [
                'feedbackRating' => 5,
                'feedbackComments' => 'Nice service!',
            ]);
        $response->assertSessionHasErrors(['bookingID']);

        // 2. Try to submit feedback for a pending booking (should fail status check)
        $response = $this->actingAs($customer, 'customer')
            ->post(route('customer.feedback.store'), [
                'bookingID' => $pendingBooking->bookingID,
                'feedbackRating' => 5,
                'feedbackComments' => 'Nice service!',
            ]);
        $response->assertSessionHasErrors(['bookingID']);

        // 3. Submit feedback for completed booking (should succeed)
        $response = $this->actingAs($customer, 'customer')
            ->post(route('customer.feedback.store'), [
                'bookingID' => $completedBooking->bookingID,
                'feedbackRating' => 5,
                'feedbackComments' => 'Great service!',
            ]);
        $response->assertRedirect(route('customer.feedback'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('feedbacks', [
            'bookingID' => $completedBooking->bookingID,
            'feedbackRating' => 5,
            'feedbackComments' => 'Great service!',
        ]);

        // 4. Try to submit feedback again for the same booking (should fail duplicate check)
        $response = $this->actingAs($customer, 'customer')
            ->post(route('customer.feedback.store'), [
                'bookingID' => $completedBooking->bookingID,
                'feedbackRating' => 4,
                'feedbackComments' => 'Another review',
            ]);
        $response->assertSessionHasErrors(['bookingID']);
    }

    public function test_staff_can_reply_to_customer_feedback()
    {
        $customer = $this->createCustomer('reviewee@example.com');
        $staff = $this->createStaff();
        
        $booking = $this->createBooking($customer, $staff, 'completed');
        
        $feedback = \App\Models\Feedback::create([
            'customerID' => $customer->customerID,
            'bookingID' => $booking->bookingID,
            'feedbackRating' => 2,
            'feedbackComments' => 'Faucets are leaking again',
        ]);

        // 1. Try to post reply as guest/customer (should fail or redirect to login)
        $response = $this->post(route('staff.feedback.reply', $feedback->feedbackID), [
            'staffResponse' => 'We will look into it',
        ]);
        $response->assertRedirect('/login');

        // 2. Post reply as staff (should succeed)
        $response = $this->actingAs($staff, 'staff')
            ->post(route('staff.feedback.reply', $feedback->feedbackID), [
                'staffResponse' => 'We are very sorry. Our technician will contact you to resolve this immediately.',
            ]);
        $response->assertRedirect(route('staff.feedback'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('feedbacks', [
            'feedbackID' => $feedback->feedbackID,
            'staffResponse' => 'We are very sorry. Our technician will contact you to resolve this immediately.',
        ]);
    }
}
