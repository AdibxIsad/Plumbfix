<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\PaymentReceipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
    /**
     * Show the custom DuitNow QR Payment Page.
     *
     * @param int $bookingID
     */
    public function showPaymentPage($bookingID)
    {
        $customer = Auth::guard('customer')->user();
        if (!$customer) {
            abort(401, 'Unauthenticated.');
        }

        $booking = Booking::where('bookingID', $bookingID)
            ->where('customerID', $customer->customerID)
            ->firstOrFail();

        if ($booking->bookingStatus === 'pending') {
            return redirect()->route('customer.bookings')->withErrors(['payment' => "Booking #{$booking->bookingID} is currently pending admin confirmation. You will be able to pay the deposit once approved."]);
        }

        return view('customer.payment', compact('booking', 'customer'));
    }

    /**
     * Handle payment receipt upload.
     *
     * @param Request $request
     * @param int $bookingID
     */
    public function uploadReceipt(Request $request, $bookingID)
    {
        $customer = Auth::guard('customer')->user();
        if (!$customer) {
            abort(401, 'Unauthenticated.');
        }

        $booking = Booking::where('bookingID', $bookingID)
            ->where('customerID', $customer->customerID)
            ->firstOrFail();

        // Prevent payment if the slot was already taken by someone else
        $conflict = Booking::where('bookingDate', $booking->bookingDate)
            ->where('bookingTime', $booking->bookingTime)
            ->where('bookingID', '!=', $booking->bookingID)
            ->whereNotIn('bookingStatus', ['cancelled'])
            ->exists();

        if ($conflict) {
            return back()->withErrors(['payment_receipt' => 'This schedule slot has already been booked and paid for by another customer. Please cancel this booking and select another time.']);
        }

        $request->validate([
            'payment_receipt' => ['required', 'file', 'mimes:jpeg,png,jpg,pdf', 'max:5120'],
            'payment_method'  => ['required', 'string', 'in:DuitNow QR,Online Banking'],
            'terms_accepted'  => ['accepted'],
        ], [
            'terms_accepted.accepted' => 'You must accept the Cancellation & Refund Policy to confirm your booking.',
        ]);

        if ($request->hasFile('payment_receipt')) {
            $file = $request->file('payment_receipt');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/receipts'), $fileName);
            $receiptPath = 'uploads/receipts/' . $fileName;

            // Save to payment_receipts table
            PaymentReceipt::create([
                'orderId'       => $booking->bookingID,
                'receiptPath'   => $receiptPath,
                'uploadedAt'    => Carbon::now('Asia/Kuala_Lumpur'),
                'status'        => 'Awaiting Verification',
                'paymentMethod' => $request->payment_method,
            ]);

            // Update bookings table (keeping old columns in sync for compatibility)
            $booking->update([
                'paymentStatus'         => 'Awaiting Verification',
                'paymentSubmittedAt'    => Carbon::now('Asia/Kuala_Lumpur'),
                'bookingDepositReceipt' => $receiptPath,
                'bookingDepositStatus'  => 'awaiting_verification',
                'paymentMethod'         => $request->payment_method,
            ]);

            // Notify staff of new receipt submission
            try {
                \Illuminate\Support\Facades\Notification::send(
                    \App\Models\Staff::all(),
                    new \App\Notifications\RecentActivityNotification("New payment receipt uploaded for Booking #{$booking->bookingID} by {$customer->customerName}.")
                );
            } catch (\Exception $e) {
                // Ignore notification issues in testing
            }

            return redirect()->route('customer.bookings')->with(
                'success',
                'Your payment receipt has been submitted successfully and is awaiting admin verification.'
            );
        }

        return back()->withErrors(['payment_receipt' => 'File upload failed. Please try again.']);
    }

    /**
     * Download receipt PDF.
     *
     * @param int $bookingID
     */
    public function downloadReceipt($bookingID, Request $request)
    {
        $booking = Booking::with('customer', 'staff')->findOrFail($bookingID);

        // Authorization checks (both customer who owns it and any staff member can download)
        $isCustomer = Auth::guard('customer')->check();
        $isStaff = Auth::guard('staff')->check();

        if (!$isCustomer && !$isStaff) {
            abort(401, 'Unauthenticated.');
        }

        if ($isCustomer) {
            $customer = Auth::guard('customer')->user();
            if ($booking->customerID !== $customer->customerID) {
                abort(403, 'Unauthorized action. You cannot view this receipt.');
            }
        }

        if ($booking->paymentStatus !== 'Paid') {
            abort(400, 'Payment receipt is only available after payment is approved/paid.');
        }

        $pdf = Pdf::loadView('pdf.receipt', compact('booking'));
        return $pdf->download('Receipt-BKG-' . $booking->bookingID . '.pdf');
    }
}
