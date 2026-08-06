<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\PaymentReceipt;
use App\Services\InventoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentVerificationController extends Controller
{
    /**
     * Helper to verify if user is authenticated staff member.
     */
    private function verifyStaff()
    {
        $staff = Auth::guard('staff')->user();
        if (!$staff) {
            abort(403, 'Unauthorized action. Staff login required.');
        }
        return $staff;
    }

    /**
     * Display all payment submissions.
     */
    public function index(Request $request)
    {
        $staff = $this->verifyStaff();

        $query = Booking::with(['customer', 'paymentReceipts', 'approver', 'staff'])
            ->whereNotNull('bookingDepositReceipt'); // Only show bookings that have submitted or initiated payment

        // Search by Order ID (Booking ID)
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function($q) use ($search) {
                if (is_numeric($search)) {
                    $q->where('bookingID', $search);
                }
                $q->orWhereHas('customer', function ($cq) use ($search) {
                    $cq->where('customerName', 'like', "%{$search}%")
                       ->orWhere('customerEmail', 'like', "%{$search}%");
                })
                ->orWhereHas('staff', function ($sq) use ($search) {
                    $sq->where('staffName', 'like', "%{$search}%");
                });
            });
        }

        // Filter by Payment Status
        if ($request->filled('status')) {
            $query->where('paymentStatus', $request->status);
        }

        // Filter by Year, Month, Day of paymentSubmittedAt
        if ($request->filled('year')) {
            $query->whereYear('paymentSubmittedAt', $request->year);
        }
        if ($request->filled('month')) {
            $query->whereMonth('paymentSubmittedAt', $request->month);
        }
        if ($request->filled('day')) {
            $query->whereDay('paymentSubmittedAt', $request->day);
        }

        $bookings = $query->orderBy('paymentSubmittedAt', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        $plumbers = \App\Models\Staff::where('status', 'active')->get();

        return view('staff.payment-verification', compact('staff', 'bookings', 'plumbers'));
    }

    /**
     * Approve Payment submission.
     */
    public function approve(Request $request, $bookingID)
    {
        $staff = $this->verifyStaff();

        // If staff is plumber (not admin), auto-assign to current staff member
        if ($staff->staffEmail !== 'admin@gmail.com') {
            $assignedStaffID = $staff->staffID;
        } else {
            $request->validate([
                'staff_id' => ['nullable', 'exists:staffs,staffID'],
            ]);
            $assignedStaffID = $request->input('staff_id') ?: $staff->staffID;
        }

        $booking = Booking::with('customer')->findOrFail($bookingID);

        // Assign Plumber and update statuses
        $booking->staffID              = $assignedStaffID;
        $booking->bookingStatus        = 'in_progress';
        $booking->paymentStatus        = 'Paid';
        $booking->bookingDepositStatus = 'paid'; // Keep in sync
        $booking->paymentApprovedAt    = Carbon::now('Asia/Kuala_Lumpur');
        $booking->approvedBy           = $staff->staffID;
        $booking->rejectionReason      = null; // Clear rejection reason if approved

        // Update payment_receipts latest status to Paid
        $latestReceipt = PaymentReceipt::where('orderId', $booking->bookingID)
            ->orderBy('uploadedAt', 'desc')
            ->first();
        if ($latestReceipt) {
            $latestReceipt->update([
                'status'  => 'Paid',
                'remarks' => 'Approved by ' . $staff->staffName . ' (ID #' . $staff->staffID . ')',
            ]);
        }

        // Deduct Inventory / Ingredients
        InventoryService::deductIngredients($booking);

        $booking->save();

        $assignedStaff = \App\Models\Staff::find($assignedStaffID);

        // Send activity notification for assignment
        try {
            if ($assignedStaff) {
                $assignedStaff->notify(new \App\Notifications\RecentActivityNotification("You have been assigned to Booking #{$booking->bookingID}."));
                
                // Send email notification with Customer contact details to assigned Staff
                if (!empty($assignedStaff->staffEmail)) {
                    $staffSubject = "New Assignment: Booking #{$booking->bookingID} — Plumbfix";
                    $staffMessage = "Hi {$assignedStaff->staffName},\n\nYou have been assigned to handle Booking #{$booking->bookingID}. Below are the customer's contact details so you can get in touch with them.";
                    $customerContactDetails = [
                        'Customer Name' => $booking->customer->customerName ?? 'N/A',
                        'Customer Phone' => $booking->customer->customerPhoneNo ?? 'N/A',
                        'Customer Email' => $booking->customer->customerEmail ?? 'N/A',
                        'Address / Location' => $booking->bookingAddress ?? $booking->customer->customerAddress ?? 'N/A',
                        'Booking Date' => $booking->bookingDate ? \Carbon\Carbon::parse($booking->bookingDate)->format('d M Y') : 'N/A',
                        'Time Slot' => $booking->bookingTimeSlot ?? 'N/A',
                    ];

                    Mail::to($assignedStaff->staffEmail)->send(new \App\Mail\ActivityNotificationMail(
                        $assignedStaff->staffName,
                        $staffMessage,
                        $staffSubject,
                        null,
                        null,
                        $customerContactDetails
                    ));
                }
            }
            if ($booking->customer) {
                $booking->customer->notify(new \App\Notifications\RecentActivityNotification("Your payment for Booking #{$booking->bookingID} has been verified and your booking is now In Progress with plumber " . ($assignedStaff->staffName ?? 'Staff') . "."));
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Failed to send staff assignment email: " . $e->getMessage());
        }

        // Send confirmation email with PDF receipt & Plumber Contact Details to Customer
        $customer = $booking->customer;
        if ($customer && !empty($customer->customerEmail)) {
            try {
                // Generate PDF receipt
                $pdf = Pdf::loadView('pdf.receipt', compact('booking'));
                $pdfData = $pdf->output();

                // Send email
                $subject = "Payment Approved & Booking In Progress — Plumbfix";
                $statusText = 'In Progress';
                $formattedDeposit = number_format($booking->bookingDepositAmount ?? 50.00, 2);
                $messageText = "Hi {$customer->customerName},\n\nWe are pleased to inform you that your deposit payment of RM {$formattedDeposit} for Booking #{$booking->bookingID} has been approved.\n\nYour booking is now in '{$statusText}' status. Below are the contact details of your assigned plumber so you can contact each other directly. Please find your official payment receipt attached.\n\nThank you for choosing Plumbfix!";
                $pdfName = "Receipt-BKG-{$booking->bookingID}.pdf";

                $plumberContactDetails = [
                    'Assigned Plumber' => $assignedStaff ? $assignedStaff->staffName : 'Plumbfix Support',
                    'Plumber Phone No' => $assignedStaff ? ($assignedStaff->staffPhoneNo ?? 'N/A') : 'N/A',
                    'Plumber Email' => $assignedStaff ? ($assignedStaff->staffEmail ?? 'N/A') : 'N/A',
                ];

                Mail::to($customer->customerEmail)->send(new \App\Mail\ActivityNotificationMail(
                    $customer->customerName,
                    $messageText,
                    $subject,
                    $pdfData,
                    $pdfName,
                    $plumberContactDetails
                ));

                // Send recent activity notification
                $customer->notify(new \App\Notifications\RecentActivityNotification("Your payment receipt for booking #{$booking->bookingID} has been approved. Status is now {$statusText}."));
            } catch (\Exception $e) {
                // Log and continue, do not block the approval if email fails
                \Illuminate\Support\Facades\Log::error("Failed to send payment approval email: " . $e->getMessage());
            }
        }

        return redirect()->route('staff.payments.index')->with(
            'success',
            'Payment approved successfully. Receipt generated and sent to customer.'
        );
    }

    /**
     * Reject Payment submission.
     */
    public function reject(Request $request, $bookingID)
    {
        $staff = $this->verifyStaff();
        
        $request->validate([
            'rejection_reason' => ['required', 'string', 'max:1000'],
        ]);

        $booking = Booking::with('customer')->findOrFail($bookingID);

        // Update booking columns
        $booking->paymentStatus = 'Rejected';
        $booking->bookingDepositStatus = 'rejected'; // Keep in sync
        $booking->paymentRejectedAt = Carbon::now('Asia/Kuala_Lumpur');
        $booking->rejectionReason = $request->rejection_reason;
        $booking->save();

        // Update payment_receipts latest status to Rejected
        $latestReceipt = PaymentReceipt::where('orderId', $booking->bookingID)
            ->orderBy('uploadedAt', 'desc')
            ->first();
        if ($latestReceipt) {
            $latestReceipt->update([
                'status'  => 'Rejected',
                'remarks' => $request->rejection_reason,
            ]);
        }

        // Notify customer
        $customer = $booking->customer;
        if ($customer) {
            try {
                $customer->notify(new \App\Notifications\RecentActivityNotification("Your payment receipt for booking #{$booking->bookingID} was rejected. Reason: {$request->rejection_reason}"));
            } catch (\Exception $e) {
                // Ignore notification issues in tests
            }
        }

        return redirect()->route('staff.payments.index')->with(
            'success',
            'Payment rejected successfully.'
        );
    }
}
