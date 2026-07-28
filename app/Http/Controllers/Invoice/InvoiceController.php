<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\JobRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    /**
     * Helper to verify invoice access and get booking/job record.
     */
    private function getInvoiceData($bookingId, $guard)
    {
        $user = Auth::guard($guard)->user();
        if (!$user) {
            abort(401, 'Unauthenticated.');
        }

        $booking = Booking::with(['customer', 'staff', 'jobRecord'])->findOrFail($bookingId);

        // Authorization checks
        if ($guard === 'customer' && $booking->customerID !== $user->customerID) {
            abort(403, 'Unauthorized action. You cannot view this invoice.');
        }
        if ($guard === 'staff' && !$user->isAdmin() && $booking->staffID !== $user->staffID) {
            abort(403, 'Unauthorized action. You cannot view this invoice.');
        }

        $jobRecord = $booking->jobRecord;
        if (!$jobRecord) {
            abort(404, 'Job completion record not found. Invoice is not generated yet.');
        }

        return [$booking, $jobRecord];
    }

    /**
     * Download the invoice PDF.
     */
    public function download($bookingId, Request $request)
    {
        $guard = $request->segment(1) === 'staff' ? 'staff' : 'customer';
        list($booking, $jobRecord) = $this->getInvoiceData($bookingId, $guard);

        $pdf = Pdf::loadView('pdf.invoice', compact('booking', 'jobRecord'));
        
        return $pdf->download('Invoice-' . sprintf('%05d', $jobRecord->jobRecordID) . '.pdf');
    }

    /**
     * Send invoice PDF to the customer via email (Triggered by Staff).
     */
    public function sendEmail($bookingId)
    {
        list($booking, $jobRecord) = $this->getInvoiceData($bookingId, 'staff');

        try {
            self::sendInvoiceEmail($booking, $jobRecord);
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Failed to send email. Details: ' . $e->getMessage()]);
        }

        return back()->with('success', 'Invoice PDF sent to customer email successfully.');
    }

    /**
     * Shared static method to send the invoice email.
     */
    public static function sendInvoiceEmail(Booking $booking, JobRecord $jobRecord)
    {
        $customer = $booking->customer;
        if (!$customer || empty($customer->customerEmail)) {
            throw new \Exception('Customer has no valid email address associated.');
        }

        // Generate PDF
        $pdf = Pdf::loadView('pdf.invoice', compact('booking', 'jobRecord'));
        $pdfData = $pdf->output();

        // Send Email using custom Mailable
        $subject = "Invoice #INV-" . sprintf('%05d', $jobRecord->jobRecordID) . " — PlumbFix";
        $messageText = "Your invoice for booking #BKG-{$booking->bookingID} is ready. Please find the attached PDF invoice for your records.";
        $pdfName = 'Invoice-' . sprintf('%05d', $jobRecord->jobRecordID) . '.pdf';

        Mail::to($customer->customerEmail)->send(new \App\Mail\ActivityNotificationMail(
            $customer->customerName,
            $messageText,
            $subject,
            $pdfData,
            $pdfName
        ));

        // Also send recent activity notification
        $customer->notify(new \App\Notifications\RecentActivityNotification("Your invoice for booking #{$booking->bookingID} has been sent to your email."));
    }
}
