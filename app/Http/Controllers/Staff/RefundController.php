<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RefundController extends Controller
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
     * Display all refund requests.
     */
    public function index(Request $request)
    {
        $staff = $this->verifyStaff();

        $query = Booking::with(['customer'])
            ->where('bookingStatus', 'cancelled')
            ->whereIn('refund_status', ['pending', 'refunded']);

        // Search by Order ID (Booking ID) or Customer Name
        if ($request->filled('search')) {
            $search = trim($request->search);
            if (is_numeric($search)) {
                $query->where('bookingID', $search);
            } else {
                $query->whereHas('customer', function ($q) use ($search) {
                    $q->where('customerName', 'like', "%{$search}%");
                });
            }
        }

        // Filter by refund status
        if ($request->filled('status')) {
            $query->where('refund_status', $request->status);
        }

        // Filter by Year, Month, Day of cancelled_at
        if ($request->filled('year')) {
            $query->whereYear('cancelled_at', $request->year);
        }
        if ($request->filled('month')) {
            $query->whereMonth('cancelled_at', $request->month);
        }
        if ($request->filled('day')) {
            $query->whereDay('cancelled_at', $request->day);
        }

        $bookings = $query->orderBy('cancelled_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('staff.refunds', compact('staff', 'bookings'));
    }

    /**
     * Complete a refund request.
     */
    public function markAsRefunded(Request $request, $id)
    {
        $staff = $this->verifyStaff();

        $booking = Booking::with('customer')
            ->where('bookingStatus', 'cancelled')
            ->where('refund_status', 'pending')
            ->findOrFail($id);

        $request->validate([
            'refund_receipt' => ['required', 'file', 'mimes:jpeg,png,jpg,pdf', 'max:4096'],
            'refund_remarks' => ['nullable', 'string', 'max:1000'],
        ]);

        $receiptPath = null;
        if ($request->hasFile('refund_receipt')) {
            $file = $request->file('refund_receipt');
            $fileName = time() . '_refund_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/refunds'), $fileName);
            $receiptPath = 'uploads/refunds/' . $fileName;
        }

        $booking->refund_status = 'refunded';
        $booking->refund_completed_at = now();
        $booking->refund_receipt_path = $receiptPath;
        $booking->refund_remarks = $request->refund_remarks;
        $booking->save();

        // Notify customer
        if ($booking->customer) {
            $formattedAmount = number_format($booking->refund_amount, 2);
            $booking->customer->notify(new \App\Notifications\RecentActivityNotification(
                "Your refund of RM {$formattedAmount} for booking #{$booking->bookingID} has been processed successfully."
            ));
            
            // Send email if they have one
            if (!empty($booking->customer->customerEmail)) {
                try {
                    $subject = "Refund Processed — Plumbfix";
                    $messageText = "Hi {$booking->customer->customerName},\n\nWe are pleased to inform you that your refund of RM {$formattedAmount} for Booking #{$booking->bookingID} has been processed successfully.\n\nThe funds have been transferred to your registered bank account. You can download the refund receipt in your customer portal.\n\nThank you for choosing Plumbfix!";
                    $pdfData = file_exists(public_path($receiptPath)) ? file_get_contents(public_path($receiptPath)) : null;
                    $pdfName = "Refund-Receipt-BKG-{$booking->bookingID}." . pathinfo($receiptPath, PATHINFO_EXTENSION);
                    
                    if ($pdfData) {
                        \Illuminate\Support\Facades\Mail::to($booking->customer->customerEmail)->send(new \App\Mail\ActivityNotificationMail(
                            $booking->customer->customerName,
                            $messageText,
                            $subject,
                            $pdfData,
                            $pdfName
                        ));
                    }
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error("Failed to send refund processed email: " . $e->getMessage());
                }
            }
        }

        return redirect()->route('staff.refunds.index')->with('success', 'Refund processed successfully.');
    }
}
