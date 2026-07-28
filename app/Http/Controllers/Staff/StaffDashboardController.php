<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class StaffDashboardController extends Controller
{
    /**
     * Show the staff dashboard.
     */
    public function index()
    {
        $staff = Auth::guard('staff')->user();

        // Fetch bookings assigned to this staff member
        $assignedBookings = Booking::where('staffID', $staff->staffID)
            ->orderByDesc('bookingDate')
            ->take(10)
            ->get();

        $totalJobs      = Booking::where('staffID', $staff->staffID)->count();
        $completedJobs  = Booking::where('staffID', $staff->staffID)->where('bookingStatus', 'completed')->count();
        $pendingJobs    = Booking::where('staffID', $staff->staffID)->whereIn('bookingStatus', ['pending', 'confirmed'])->count();
        $ongoingJobs    = Booking::where('staffID', $staff->staffID)->where('bookingStatus', 'in_progress')->count();

        return view('staff.dashboard', compact(
            'staff',
            'assignedBookings',
            'totalJobs',
            'completedJobs',
            'pendingJobs',
            'ongoingJobs'
        ));
    }

    /**
     * Log the staff member out.
     */
    public function logout(\Illuminate\Http\Request $request)
    {
        Auth::guard('staff')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
