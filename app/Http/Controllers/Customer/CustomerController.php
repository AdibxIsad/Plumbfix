<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Customer Dashboard
     */
    public function dashboard()
    {
        $customer = Auth::guard('customer')->user();

        $totalBookings    = Booking::where('customerID', $customer->customerID)->count();
        $pendingBookings  = Booking::where('customerID', $customer->customerID)->where('bookingStatus', 'pending')->count();
        $confirmedBookings = Booking::where('customerID', $customer->customerID)->where('bookingStatus', 'confirmed')->count();
        $completedBookings = Booking::where('customerID', $customer->customerID)->where('bookingStatus', 'completed')->count();

        $recentBookings = Booking::where('customerID', $customer->customerID)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $nextBooking = Booking::where('customerID', $customer->customerID)
            ->whereIn('bookingStatus', ['pending', 'confirmed'])
            ->where('bookingDate', '>=', now()->toDateString())
            ->orderBy('bookingDate', 'asc')
            ->orderBy('bookingTime', 'asc')
            ->first();

        return view('customer.dashboard', compact(
            'customer',
            'totalBookings',
            'pendingBookings',
            'confirmedBookings',
            'completedBookings',
            'recentBookings',
            'nextBooking'
        ));
    }

    /* ─────────────────────────── PROFILE ─────────────────────────── */

    public function profile()
    {
        $customer = Auth::guard('customer')->user();
        return view('customer.profile', compact('customer'));
    }

    public function profileUpdate(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        $request->validate([
            'customerName'          => ['required', 'string', 'max:255'],
            'customerPhoneNo'       => ['nullable', 'string', 'max:20'],
            'customerAddress'       => ['nullable', 'string', 'max:500'],
            'customerBankName'      => ['nullable', 'string', 'max:255'],
            'customerBankAccountNo' => ['nullable', 'string', 'max:50'],
            'current_password'      => ['nullable', 'string'],
            'new_password'          => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        // Password change requested
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $customer->customerPassword)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.'])->withInput();
            }
            $customer->customerPassword = Hash::make($request->new_password);
        }

        $customer->customerName          = $request->customerName;
        $customer->customerPhoneNo       = $request->customerPhoneNo;
        $customer->customerAddress       = $request->customerAddress;
        $customer->customerBankName      = $request->customerBankName;
        $customer->customerBankAccountNo = $request->customerBankAccountNo;
        $customer->save();

        return redirect()->route('customer.profile')->with('success', 'Profile updated successfully!');
    }

    /* ─────────────────────────── BOOKINGS ─────────────────────────── */

    public function bookings(Request $request)
    {
        $customer = Auth::guard('customer')->user();
        
        $query = Booking::where('customerID', $customer->customerID)->with('staff');

        // Apply Year Filter
        if ($request->filled('year')) {
            $query->whereYear('bookingDate', $request->year);
        }

        // Apply Month Filter
        if ($request->filled('month')) {
            $query->whereMonth('bookingDate', $request->month);
        }

        // Apply Day/Date Filter
        if ($request->filled('date')) {
            $query->whereDate('bookingDate', $request->date);
        }

        $bookings = $query->orderBy('bookingDate', 'desc')
            ->orderBy('bookingTime', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('customer.bookings', compact('customer', 'bookings'));
    }

    public function bookingCreate()
    {
        $customer = Auth::guard('customer')->user();
        if (empty($customer->customerPhoneNo) || empty($customer->customerAddress) || empty($customer->customerBankName) || empty($customer->customerBankAccountNo)) {
            return redirect()->route('customer.profile')->withErrors([
                'profile_required' => 'Please update your phone number, address, bank name, and bank account number in your profile before making a booking.'
            ]);
        }
        return view('customer.booking-create', compact('customer'));
    }
    public function bookingStore(Request $request)
    {
        $customer = Auth::guard('customer')->user();
        if (empty($customer->customerPhoneNo) || empty($customer->customerAddress) || empty($customer->customerBankName) || empty($customer->customerBankAccountNo)) {
            return redirect()->route('customer.profile')->withErrors([
                'profile_required' => 'Please update your phone number, address, bank name, and bank account number in your profile before making a booking.'
            ]);
        }

        $request->validate([
            'bookingType'             => ['required', 'string', 'max:255'],
            'bookingProblem'          => ['required', 'string', 'max:255'],
            'bookingIssueDescription' => ['nullable', 'string', 'max:1000'],
            'bookingDate'             => ['required', 'date', 'after_or_equal:today'],
            'bookingTime'             => ['required', 'string'],
            'bookingAttachment'       => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:4096'],
        ]);

        // Validate slot is available for the day
        $date = $request->bookingDate;
        $dayOfWeek = \Carbon\Carbon::parse($date)->dayOfWeek; // 0=Sunday, 5=Friday

        $fridaySlots   = ['08:00:00', '10:00:00', '15:00:00'];
        $regularSlots  = ['08:00:00', '10:00:00', '12:00:00', '14:00:00', '16:00:00'];

        $allowedSlots = ($dayOfWeek === 5) ? $fridaySlots : $regularSlots;

        if (!in_array($request->bookingTime, $allowedSlots)) {
            return back()->withErrors(['bookingTime' => 'This time slot is not available for the selected date.'])->withInput();
        }

        // Enforce 12-hour minimum lead time restriction
        $bookingDateTime = \Carbon\Carbon::parse($date . ' ' . $request->bookingTime, 'Asia/Kuala_Lumpur');
        $now = now('Asia/Kuala_Lumpur');

        if ($bookingDateTime->lt($now->copy()->addHours(12))) {
            return back()->withErrors(['bookingTime' => 'Bookings must be made at least 12 hours in advance. Please select a later date or time slot.'])->withInput();
        }

        // Check if slot is already taken on that date (only count slots that are not cancelled)
        $conflict = Booking::where('bookingDate', $date)
            ->where('bookingTime', $request->bookingTime)
            ->whereNotIn('bookingStatus', ['cancelled'])
            ->exists();

        if ($conflict) {
            return back()->withErrors(['bookingTime' => 'This slot is already booked. Please choose another slot.'])->withInput();
        }

        $attachmentPath = null;
        if ($request->hasFile('bookingAttachment')) {
            $file = $request->file('bookingAttachment');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/bookings'), $fileName);
            $attachmentPath = 'uploads/bookings/' . $fileName;
        }

        $booking = Booking::create([
            'customerID'              => $customer->customerID,
            'bookingType'             => $request->bookingType,
            'bookingProblem'          => $request->bookingProblem,
            'bookingIssueDescription' => $request->bookingIssueDescription,
            'bookingDate'             => $date,
            'bookingTime'             => $request->bookingTime,
            'bookingStatus'           => 'pending',
            'bookingAttachment'       => $attachmentPath,
            'bookingDepositReceipt'   => null,
            'bookingDepositAmount'    => 50.00,
            'bookingDepositStatus'    => 'pending',
            'paymentStatus'           => 'Pending',
        ]);
        \Illuminate\Support\Facades\Notification::send(
            \App\Models\Staff::all(), 
            new \App\Notifications\RecentActivityNotification("New booking #{$booking->bookingID} received from {$customer->customerName}.")
        );

        return redirect()->route('customer.bookings')->with('success', "Booking #{$booking->bookingID} submitted successfully! Please wait for admin approval before paying the deposit.");
    }

    /**
     * Get booked slots for a given date
     */
    public function getBookedSlots(Request $request)
    {
        $request->validate([
            'date' => ['required', 'date'],
        ]);

        $bookedSlots = Booking::where('bookingDate', $request->date)
            ->whereNotIn('bookingStatus', ['cancelled'])
            ->pluck('bookingTime')
            ->toArray();

        return response()->json($bookedSlots);
    }
    public function confirmCancel($id)
    {
        $customer = Auth::guard('customer')->user();
        $booking  = Booking::where('bookingID', $id)->where('customerID', $customer->customerID)->firstOrFail();

        if (in_array($booking->bookingStatus, ['completed', 'cancelled'])) {
            return redirect()->route('customer.bookings')->withErrors(['delete' => 'This booking cannot be cancelled in its current state.']);
        }

        return view('customer.cancel-confirm', compact('booking'));
    }

    public function bookingDelete(Request $request, $id)
    {
        $customer = Auth::guard('customer')->user();
        $booking  = Booking::where('bookingID', $id)->where('customerID', $customer->customerID)->firstOrFail();

        if (in_array($booking->bookingStatus, ['completed', 'cancelled'])) {
            return redirect()->route('customer.bookings')->withErrors(['delete' => 'This booking cannot be cancelled in its current state.']);
        }

        $request->validate([
            'cancellation_reason' => ['required', 'string', 'max:255'],
            'cancellation_description' => ['nullable', 'string', 'max:1000'],
        ]);

        // Calculate refund
        $refundInfo = $booking->calculateRefundEligibility();

        // Perform soft cancellation
        $booking->bookingStatus = 'cancelled';
        if ($booking->paymentStatus === 'Pending') {
            $booking->paymentStatus = 'Cancelled';
        }
        $booking->cancelled_at = now();
        $booking->cancellation_reason = $request->cancellation_reason;
        $booking->cancellation_description = $request->cancellation_description;
        $booking->refund_status = $refundInfo['eligible'] ? 'pending' : 'not_applicable';
        $booking->refund_amount = $refundInfo['amount'];
        $booking->save();

        // Notify assigned staff or all staff on status update / cancellation
        $cancelMsg = "Booking #{$booking->bookingID} has been cancelled by {$customer->customerName}.";
        if ($booking->staffID) {
            if ($booking->staff) {
                $booking->staff->notify(new \App\Notifications\RecentActivityNotification($cancelMsg));
            }
        } else {
            \Illuminate\Support\Facades\Notification::send(
                \App\Models\Staff::all(),
                new \App\Notifications\RecentActivityNotification($cancelMsg)
            );
        }

        $successMsg = 'Booking cancelled successfully.';
        if ($refundInfo['eligible']) {
            $successMsg .= ' A refund of RM ' . number_format($refundInfo['amount'], 2) . ' is pending process.';
        } else {
            $successMsg .= ' Deposit was non-refundable.';
        }

        return redirect()->route('customer.bookings')->with('success', $successMsg);
    }

    /* ─────────────────────────── FEEDBACK ─────────────────────────── */

    public function feedback()
    {
        $customer    = Auth::guard('customer')->user();
        $allFeedback = Feedback::with(['customer', 'booking'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Get completed bookings for this customer that don't have feedback yet
        $completedBookingsWithoutFeedback = \App\Models\Booking::where('customerID', $customer->customerID)
            ->where('bookingStatus', 'completed')
            ->doesntHave('feedback')
            ->get();

        $selectedBookingID = request('bookingID');

        return view('customer.feedback', compact('customer', 'allFeedback', 'completedBookingsWithoutFeedback', 'selectedBookingID'));
    }

    public function feedbackStore(Request $request)
    {
        $customer = Auth::guard('customer')->user();

        $request->validate([
            'bookingID'              => ['required', 'integer', 'exists:bookings,bookingID'],
            'feedbackRating'         => ['required', 'integer', 'min:1', 'max:5'],
            'feedbackComments'       => ['nullable', 'string', 'max:1000'],
            'feedbackAttachments'    => ['nullable', 'array'],
            'feedbackAttachments.*'  => ['file', 'mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx', 'max:4096'],
        ]);

        $booking = \App\Models\Booking::where('bookingID', $request->bookingID)
            ->where('customerID', $customer->customerID)
            ->first();

        if (!$booking) {
            return redirect()->back()->withInput()->withErrors(['bookingID' => 'Invalid booking selected.']);
        }

        if ($booking->bookingStatus !== 'completed') {
            return redirect()->back()->withInput()->withErrors(['bookingID' => 'Feedback can only be submitted for completed services.']);
        }

        if ($booking->feedback()->exists()) {
            return redirect()->back()->withInput()->withErrors(['bookingID' => 'You have already submitted feedback for this service.']);
        }

        $attachmentPaths = [];
        if ($request->hasFile('feedbackAttachments')) {
            foreach ($request->file('feedbackAttachments') as $file) {
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/feedback'), $fileName);
                $attachmentPaths[] = 'uploads/feedback/' . $fileName;
            }
        }

        Feedback::create([
            'customerID'          => $customer->customerID,
            'bookingID'           => $request->bookingID,
            'feedbackRating'      => $request->feedbackRating,
            'feedbackComments'    => $request->feedbackComments,
            'feedbackAttachments' => $attachmentPaths,
        ]);

        \Illuminate\Support\Facades\Notification::send(
            \App\Models\Staff::all(), 
            new \App\Notifications\RecentActivityNotification("New feedback submitted by {$customer->customerName}.")
        );

        return redirect()->route('customer.feedback')->with('success', 'Thank you for your feedback!');
    }
}
