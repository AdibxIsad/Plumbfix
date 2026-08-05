<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Feedback;
use App\Models\JobRecord;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    private function staff()
    {
        return Auth::guard('staff')->user();
    }

    /* ─────────────────── DASHBOARD ─────────────────── */

    public function dashboard(Request $request)
    {
        $staff = $this->staff();

        // 1. Statistics Cards & Dynamic Trends
        $totalActiveClients = \App\Models\Customer::count();
        $pendingOrders      = Booking::whereIn('bookingStatus', ['pending', 'confirmed'])
            ->where('paymentStatus', '!=', 'Pending')
            ->count();
        $completedJobs      = Booking::where('bookingStatus', 'completed')->count();
        $totalSales         = \App\Models\JobRecord::sum('jobRecordTotalCost');

        // Dynamic trend calculations
        // Clients registered this month
        $newClientsThisMonth = \App\Models\Customer::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();
        
        // Pending bookings received today (excluding unpaid)
        $newBookingsToday = Booking::whereIn('bookingStatus', ['pending', 'confirmed'])
            ->where('paymentStatus', '!=', 'Pending')
            ->whereDate('created_at', today())
            ->count();
        
        // Completed jobs this month vs last month growth
        $completedThisMonth = Booking::where('bookingStatus', 'completed')
            ->whereYear('bookingDate', now()->year)
            ->whereMonth('bookingDate', now()->month)
            ->count();
        $completedLastMonth = Booking::where('bookingStatus', 'completed')
            ->whereYear('bookingDate', now()->subMonth()->year)
            ->whereMonth('bookingDate', now()->subMonth()->month)
            ->count();
        $jobsGrowth = 0.0;
        if ($completedLastMonth > 0) {
            $jobsGrowth = (($completedThisMonth - $completedLastMonth) / $completedLastMonth) * 100;
        } else {
            $jobsGrowth = $completedThisMonth > 0 ? 100.0 : 0.0;
        }

        // Sales completed this month vs last month growth
        $salesThisMonth = \App\Models\JobRecord::whereYear('jobRecordCompletionDate', now()->year)
            ->whereMonth('jobRecordCompletionDate', now()->month)
            ->sum('jobRecordTotalCost');
        $salesLastMonth = \App\Models\JobRecord::whereYear('jobRecordCompletionDate', now()->subMonth()->year)
            ->whereMonth('jobRecordCompletionDate', now()->subMonth()->month)
            ->sum('jobRecordTotalCost');
        $salesGrowth = 0.0;
        if ($salesLastMonth > 0) {
            $salesGrowth = (($salesThisMonth - $salesLastMonth) / $salesLastMonth) * 100;
        } else {
            $salesGrowth = $salesThisMonth > 0 ? 100.0 : 0.0;
        }

        $yearExpr = match (\Illuminate\Support\Facades\DB::getDriverName()) {
            'pgsql' => 'EXTRACT(YEAR FROM "jobRecordCompletionDate")::integer as year',
            'sqlite' => 'cast(strftime("%Y", "jobRecordCompletionDate") as integer) as year',
            default => 'YEAR(jobRecordCompletionDate) as year',
        };

        // Get available years for dropdown filter
        $years = \App\Models\JobRecord::selectRaw($yearExpr)
            ->whereNotNull('jobRecordCompletionDate')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        if (empty($years)) {
            $years = [(int)date('Y'), (int)date('Y') - 1];
        }

        $selectedYear = (int)$request->input('chart_year', date('Y'));

        // 2. Chart Data (Monthly Sales)
        $monthlyData = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthlyData[$m] = [
                'month_name' => date('M', mktime(0, 0, 0, $m, 1)),
                'month_full_name' => date('F', mktime(0, 0, 0, $m, 1)),
                'sales' => 0.0,
            ];
        }

        // Sum completed job costs by month for selected year
        $jobRecords = \App\Models\JobRecord::whereYear('jobRecordCompletionDate', $selectedYear)
            ->with('booking')
            ->get();

        foreach ($jobRecords as $record) {
            if ($record->booking && $record->booking->bookingDate) {
                // Parse date safely
                $dateVal = $record->booking->bookingDate;
                $month = (int)(is_string($dateVal) ? date('m', strtotime($dateVal)) : $dateVal->format('m'));
                $cost = (double)$record->jobRecordTotalCost;
                
                $monthlyData[$month]['sales'] += $cost;
            }
        }

        // Determine dynamic Y-axis scale
        $maxMonthTotal = 0;
        foreach ($monthlyData as $data) {
            if ($data['sales'] > $maxMonthTotal) {
                $maxMonthTotal = $data['sales'];
            }
        }

        $yMax = $maxMonthTotal > 0 ? ceil($maxMonthTotal / 1000) * 1000 : 8000;
        if ($yMax < 1000) $yMax = 1000;

        // Formulate labels
        if ($yMax >= 10000) {
            $yLabels = [
                'RM ' . number_format($yMax / 1000, 0) . 'k',
                'RM ' . number_format(($yMax * 0.75) / 1000, 0) . 'k',
                'RM ' . number_format(($yMax * 0.5) / 1000, 0) . 'k',
                'RM ' . number_format(($yMax * 0.25) / 1000, 0) . 'k',
                'RM 0'
            ];
        } else {
            $yLabels = [
                'RM ' . number_format($yMax, 0),
                'RM ' . number_format($yMax * 0.75, 0),
                'RM ' . number_format($yMax * 0.5, 0),
                'RM ' . number_format($yMax * 0.25, 0),
                'RM 0'
            ];
        }

        // Calculate height percentages and identify max month for tooltip
        $highestMonthIndex = 1; // Default to Jan
        $highestMonthRevenue = -1;
        
        foreach ($monthlyData as $m => &$data) {
            $totalRev = $data['sales'];
            if ($totalRev > $highestMonthRevenue && $totalRev > 0) {
                $highestMonthRevenue = $totalRev;
                $highestMonthIndex = $m;
            }
            $data['sales_height'] = $yMax > 0 ? ($data['sales'] / $yMax) * 100 : 0;
            
            // MoM Growth calculation
            $prevMonth = $m - 1;
            if ($prevMonth < 1) {
                $data['growth'] = 0.0;
            } else {
                $currentTotal = $data['sales'];
                $prevTotal = $monthlyData[$prevMonth]['sales'];
                if ($prevTotal > 0) {
                    $data['growth'] = (($currentTotal - $prevTotal) / $prevTotal) * 100;
                } else {
                    $data['growth'] = $currentTotal > 0 ? 100.0 : 0.0;
                }
            }
        }
        unset($data);

        // 3. Recent Activities (including Pending Payment Verifications and Pending Refunds)
        $recentActivities = Booking::with(['customer', 'staff', 'paymentReceipts'])
            ->orderBy('created_at', 'desc')
            ->take(50)
            ->get();

        // 4. Plumbers List
        $plumbers = \App\Models\Staff::where('staffEmail', '!=', 'admin@gmail.com')
            ->withCount(['bookings' => function($q) {
                $q->where('bookingStatus', 'completed');
            }])
            ->orderBy('bookings_count', 'desc')
            ->take(5)
            ->get();

        // 5. Ongoing Jobs Table
        $ongoingJobs = Booking::with(['customer', 'staff'])
            ->whereIn('bookingStatus', ['in_progress', 'confirmed', 'completed'])
            ->orderBy('bookingDate', 'desc')
            ->take(5)
            ->get();

        return view('staff.dashboard', compact(
            'staff',
            'totalActiveClients',
            'pendingOrders',
            'completedJobs',
            'totalSales',
            'newClientsThisMonth',
            'newBookingsToday',
            'jobsGrowth',
            'salesGrowth',
            'monthlyData',
            'yLabels',
            'highestMonthIndex',
            'recentActivities',
            'plumbers',
            'ongoingJobs',
            'years',
            'selectedYear'
        ));
    }

    /* ─────────────────── PROFILE ─────────────────── */

    public function profile()
    {
        $staff = $this->staff();
        return view('staff.profile', compact('staff'));
    }

    public function profileUpdate(Request $request)
    {
        $staff = $this->staff();

        $request->validate([
            'staffName'        => ['required', 'string', 'max:255'],
            'staffPhoneNo'     => ['nullable', 'string', 'max:20'],
            'avatar'           => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'current_password' => ['nullable', 'string'],
            'new_password'     => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/avatars'), $fileName);
            $staff->avatar = 'uploads/avatars/' . $fileName;
        }

        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $staff->staffPassword)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.'])->withInput();
            }
            $staff->staffPassword = Hash::make($request->new_password);
        }

        $staff->staffName    = $request->staffName;
        $staff->staffPhoneNo = $request->staffPhoneNo;
        $staff->save();

        return redirect()->route('staff.profile')->with('success', 'Profile updated successfully!');
    }

    /* ─────────────────── BOOKINGS ─────────────────── */

    public function bookings(Request $request)
    {
        $staff = $this->staff();

        $query = Booking::with(['customer', 'jobRecord', 'staff']);

        // Search by Booking ID or Customer Name
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

        if ($request->filled('status')) {
            $query->where('bookingStatus', $request->status);
        }

        // Apply Year Filter
        if ($request->filled('year')) {
            $query->whereYear('bookingDate', $request->year);
        }

        // Apply Month Filter
        if ($request->filled('month')) {
            $query->whereMonth('bookingDate', $request->month);
        }

        // Apply Day Filter
        if ($request->filled('day')) {
            $query->whereDay('bookingDate', $request->day);
        }

        $bookings = $query->orderByDesc('bookingDate')->paginate(10)->withQueryString();

        // Unassigned / Pending bookings for staff/admin to confirm and accept
        $unassigned = Booking::where(function($q) {
                $q->whereNull('staffID')->orWhere('bookingStatus', 'pending');
            })
            ->whereNotIn('bookingStatus', ['cancelled'])
            ->with('customer')
            ->orderBy('bookingDate')->take(20)->get();

        return view('staff.bookings', compact('staff', 'bookings', 'unassigned'));
    }

    public function bookingUpdateStatus(Request $request, $id)
    {
        $staff   = $this->staff();
        $booking = Booking::where('bookingID', $id)->firstOrFail();

        $request->validate([
            'bookingStatus' => ['required', 'in:confirmed,in_progress,completed,cancelled'],
        ]);

        $currentStatus = $booking->bookingStatus;
        $newStatus = $request->bookingStatus;

        $transitions = [
            'pending'     => ['confirmed', 'in_progress', 'cancelled'],
            'confirmed'   => ['in_progress', 'cancelled'],
            'in_progress' => ['completed', 'cancelled'],
            'completed'   => [],
            'cancelled'   => [],
        ];

        if (!isset($transitions[$currentStatus]) || !in_array($newStatus, $transitions[$currentStatus])) {
            return back()->withErrors(['bookingStatus' => "Invalid status transition from {$currentStatus} to {$newStatus}."]);
        }

        if ($newStatus === 'completed') {
            $dateStr = $booking->bookingDate instanceof \Carbon\Carbon 
                ? $booking->bookingDate->format('Y-m-d') 
                : \Carbon\Carbon::parse($booking->bookingDate)->format('Y-m-d');
            $bookingDateTime = \Carbon\Carbon::parse($dateStr . ' ' . $booking->bookingTime);
            if (now()->lt($bookingDateTime)) {
                return back()->withErrors(['bookingStatus' => 'Cannot mark booking as completed before its scheduled date and time has passed.']);
            }
        }

        $booking->bookingStatus = $request->bookingStatus;
        if ($request->bookingStatus === 'cancelled' && $booking->paymentStatus === 'Pending') {
            $booking->paymentStatus = 'Cancelled';
        }
        $booking->save();

        if ($booking->customer) {
            try {
                $status = ucwords(str_replace('_', ' ', $request->bookingStatus));
                $booking->customer->notify(new \App\Notifications\RecentActivityNotification("Your booking #{$booking->bookingID} status changed to {$status}."));
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error('Booking update notification error: ' . $e->getMessage());
            }
        }

        return redirect()->route('staff.bookings')->with('success', 'Booking status updated.');
    }

    public function bookingAccept($id)
    {
        $staff   = $this->staff();
        $booking = Booking::where('bookingID', $id)->firstOrFail();

        if ($booking->bookingStatus === 'cancelled') {
            return back()->withErrors(['bookingStatus' => 'Cannot accept a cancelled booking.']);
        }

        $booking->staffID       = $staff->staffID;
        $booking->bookingStatus = 'confirmed';
        $booking->save();

        if ($booking->customer) {
            try {
                $booking->customer->notify(new \App\Notifications\RecentActivityNotification("Your booking #{$booking->bookingID} has been approved by admin ({$staff->staffName})! You can now proceed to pay your deposit."));
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error('Booking accept notification error: ' . $e->getMessage());
            }
        }

        return redirect()->route('staff.bookings')->with('success', "Booking #{$booking->bookingID} confirmed and assigned!");
    }

    /* ─────────────────── JOB RECORDS ─────────────────── */

    public function jobRecords(Request $request)
    {
        $staff = $this->staff();

        // Determine active tab
        $activeTab = $request->input('tab', 'report');

        // Job records query for records tab
        $query = JobRecord::with(['booking.customer', 'staff'])
            ->orderByDesc('jobRecordCompletionDate');

        // Search by Booking ID or Customer Name
        if ($request->filled('search')) {
            $search = trim($request->search);
            if (is_numeric($search)) {
                $query->where('bookingID', $search);
            } else {
                $query->whereHas('booking.customer', function ($q) use ($search) {
                    $q->where('customerName', 'like', "%{$search}%");
                });
            }
        }

        // Apply Year Filter
        if ($request->filled('year')) {
            $query->whereYear('jobRecordCompletionDate', $request->year);
        }

        // Apply Month Filter
        if ($request->filled('month')) {
            $query->whereMonth('jobRecordCompletionDate', $request->month);
        }

        // Apply Day Filter
        if ($request->filled('day')) {
            $query->whereDay('jobRecordCompletionDate', $request->day);
        }

        $jobRecords = $query->paginate(12)->withQueryString();

        // Completed bookings that don't yet have a job record
        $completedWithoutRecord = Booking::where('staffID', $staff->staffID)
            ->where('bookingStatus', 'completed')
            ->whereNotIn('bookingID', JobRecord::where('staffID', $staff->staffID)->pluck('bookingID'))
            ->get();

        // Compile report data for staff & admin
        $reportData = [];
        if ($staff) {
            $selectedYear = (int)$request->input('report_year', date('Y'));
            $selectedMonth = $request->input('report_month', ''); // Empty means All Months

            if ($selectedMonth !== '') {
                $selectedMonth = (int)$selectedMonth;
                // Monthly Revenue Metrics
                $revenueThisMonth = JobRecord::whereYear('jobRecordCompletionDate', $selectedYear)
                    ->whereMonth('jobRecordCompletionDate', $selectedMonth)
                    ->sum('jobRecordTotalCost');
                
                // revenue for previous month
                $prevMonth = $selectedMonth - 1;
                $prevYear = $selectedYear;
                if ($prevMonth == 0) {
                    $prevMonth = 12;
                    $prevYear = $selectedYear - 1;
                }
                $revenueLastMonth = JobRecord::whereYear('jobRecordCompletionDate', $prevYear)
                    ->whereMonth('jobRecordCompletionDate', $prevMonth)
                    ->sum('jobRecordTotalCost');
                
                // Booking Counts for this month
                $bookingsCount = Booking::whereYear('bookingDate', $selectedYear)
                    ->whereMonth('bookingDate', $selectedMonth)
                    ->count();
                $bookingsCompleted = Booking::whereYear('bookingDate', $selectedYear)
                    ->whereMonth('bookingDate', $selectedMonth)
                    ->where('bookingStatus', 'completed')
                    ->count();
                $bookingsPending = Booking::whereYear('bookingDate', $selectedYear)
                    ->whereMonth('bookingDate', $selectedMonth)
                    ->where('bookingStatus', 'pending')
                    ->count();
                $bookingsCancelled = Booking::whereYear('bookingDate', $selectedYear)
                    ->whereMonth('bookingDate', $selectedMonth)
                    ->where('bookingStatus', 'cancelled')
                    ->count();

                // Customer Satisfaction (Feedback) for this month
                $allFeedback = Feedback::whereHas('booking', function($q) use ($selectedYear, $selectedMonth) {
                    $q->whereYear('bookingDate', $selectedYear)->whereMonth('bookingDate', $selectedMonth);
                })->get();
            } else {
                // Yearly Revenue Metrics
                $revenueThisMonth = JobRecord::whereYear('jobRecordCompletionDate', $selectedYear)
                    ->sum('jobRecordTotalCost');
                
                // revenue for previous year
                $revenueLastMonth = JobRecord::whereYear('jobRecordCompletionDate', $selectedYear - 1)
                    ->sum('jobRecordTotalCost');
                
                // Booking Counts for this year
                $bookingsCount = Booking::whereYear('bookingDate', $selectedYear)->count();
                $bookingsCompleted = Booking::whereYear('bookingDate', $selectedYear)->where('bookingStatus', 'completed')->count();
                $bookingsPending = Booking::whereYear('bookingDate', $selectedYear)->where('bookingStatus', 'pending')->count();
                $bookingsCancelled = Booking::whereYear('bookingDate', $selectedYear)->where('bookingStatus', 'cancelled')->count();

                // Customer Satisfaction (Feedback) for this year
                $allFeedback = Feedback::whereHas('booking', function($q) use ($selectedYear) {
                    $q->whereYear('bookingDate', $selectedYear);
                })->get();
            }

            $totalRevenueAllTime = JobRecord::sum('jobRecordTotalCost');
            
            $revenueGrowth = 0.0;
            if ($revenueLastMonth > 0) {
                $revenueGrowth = (($revenueThisMonth - $revenueLastMonth) / $revenueLastMonth) * 100;
            } else {
                $revenueGrowth = $revenueThisMonth > 0 ? 100.0 : 0.0;
            }

            $avgFeedbackRating = $allFeedback->avg('feedbackRating') ?? 0.0;
            $satisfactionCount = $allFeedback->count();
            
            $ratingBreakdown = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
            foreach ($allFeedback as $fb) {
                $r = (int)$fb->feedbackRating;
                if ($r >= 1 && $r <= 5) {
                    $ratingBreakdown[$r]++;
                }
            }

            // Get available years for report
            $yearsReportExpr = match (\Illuminate\Support\Facades\DB::getDriverName()) {
                'pgsql' => 'EXTRACT(YEAR FROM "jobRecordCompletionDate")::integer as year',
                'sqlite' => 'cast(strftime("%Y", "jobRecordCompletionDate") as integer) as year',
                default => 'YEAR(jobRecordCompletionDate) as year',
            };

            $reportYears = JobRecord::selectRaw($yearsReportExpr)
                ->whereNotNull('jobRecordCompletionDate')
                ->distinct()
                ->orderBy('year', 'desc')
                ->pluck('year')
                ->toArray();
            if (empty($reportYears)) {
                $reportYears = [(int)date('Y')];
            }

            // Compile chart data
            $monthlyReportData = [];
            if ($selectedMonth !== '') {
                // Weekly breakdown for the selected month
                for ($w = 1; $w <= 4; $w++) {
                    $monthlyReportData[$w] = [
                        'month_name' => 'Wk ' . $w,
                        'revenue' => 0.0,
                        'bookings' => 0
                    ];
                }

                // Populate weekly revenue
                $recordsForMonth = JobRecord::whereYear('jobRecordCompletionDate', $selectedYear)
                    ->whereMonth('jobRecordCompletionDate', $selectedMonth)
                    ->get();
                foreach ($recordsForMonth as $jr) {
                    $day = (int)$jr->jobRecordCompletionDate->format('d');
                    if ($day <= 7) $w = 1;
                    elseif ($day <= 14) $w = 2;
                    elseif ($day <= 21) $w = 3;
                    else $w = 4;
                    $monthlyReportData[$w]['revenue'] += (double)$jr->jobRecordTotalCost;
                }

                // Populate weekly bookings
                $bookingsForMonth = Booking::whereYear('bookingDate', $selectedYear)
                    ->whereMonth('bookingDate', $selectedMonth)
                    ->get();
                foreach ($bookingsForMonth as $bk) {
                    $day = (int)$bk->bookingDate->format('d');
                    if ($day <= 7) $w = 1;
                    elseif ($day <= 14) $w = 2;
                    elseif ($day <= 21) $w = 3;
                    else $w = 4;
                    $monthlyReportData[$w]['bookings'] += 1;
                }
            } else {
                // Monthly breakdown for the selected year
                for ($m = 1; $m <= 12; $m++) {
                    $monthlyReportData[$m] = [
                        'month_name' => date('M', mktime(0, 0, 0, $m, 1)),
                        'revenue' => 0.0,
                        'bookings' => 0
                    ];
                }

                // Populate revenue
                $recordsForYear = JobRecord::whereYear('jobRecordCompletionDate', $selectedYear)->get();
                foreach ($recordsForYear as $jr) {
                    $m = (int)$jr->jobRecordCompletionDate->format('m');
                    $monthlyReportData[$m]['revenue'] += (double)$jr->jobRecordTotalCost;
                }

                // Populate booking counts
                $bookingsForYear = Booking::whereYear('bookingDate', $selectedYear)->get();
                foreach ($bookingsForYear as $bk) {
                    $m = (int)$bk->bookingDate->format('m');
                    $monthlyReportData[$m]['bookings'] += 1;
                }
            }

            // Calculate chart parameters
            $maxRevenue = 0.0;
            $maxBookings = 0;
            foreach ($monthlyReportData as $data) {
                if ($data['revenue'] > $maxRevenue) $maxRevenue = $data['revenue'];
                if ($data['bookings'] > $maxBookings) $maxBookings = $data['bookings'];
            }

            $chartMaxRevenue = $maxRevenue > 0 ? ceil($maxRevenue / 1000) * 1000 : 5000;
            if ($chartMaxRevenue < 1000) $chartMaxRevenue = 1000;

            $chartMaxBookings = $maxBookings > 0 ? ceil($maxBookings / 10) * 10 : 20;

            $reportData = compact(
                'revenueThisMonth',
                'revenueLastMonth',
                'totalRevenueAllTime',
                'revenueGrowth',
                'bookingsCount',
                'bookingsCompleted',
                'bookingsPending',
                'bookingsCancelled',
                'avgFeedbackRating',
                'satisfactionCount',
                'ratingBreakdown',
                'selectedYear',
                'selectedMonth',
                'reportYears',
                'monthlyReportData',
                'chartMaxRevenue',
                'chartMaxBookings'
            );
        }

        return view('staff.job-records', compact(
            'staff',
            'jobRecords',
            'completedWithoutRecord',
            'activeTab',
            'reportData'
        ));
    }

    public function jobRecordCreate($bookingId)
    {
        $staff   = $this->staff();
        $booking = Booking::where('bookingID', $bookingId)->firstOrFail();

        $jobRecord = JobRecord::where('bookingID', $bookingId)->first();

        return view('staff.job-record-create', compact('staff', 'booking', 'jobRecord'));
    }

    public function jobRecordStore(Request $request)
    {
        $staff = $this->staff();

        $request->validate([
            'bookingID'               => ['required', 'exists:bookings,bookingID'],
            'jobRecordCompletionDate' => ['required', 'date', 'before_or_equal:today'],
            'jobRecordTotalCost'      => ['required', 'numeric', 'min:0'],
            'jobRecordNotes'          => ['nullable', 'string', 'max:2000'],
            'jobRecordAttachments'    => ['nullable', 'array'],
            'jobRecordAttachments.*'  => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:4096'],
        ]);

        $jobRecord = JobRecord::where('bookingID', $request->bookingID)->first();

        $attachmentPaths = $jobRecord ? ($jobRecord->jobRecordAttachments ?? []) : [];
        if ($request->hasFile('jobRecordAttachments')) {
            foreach ($request->file('jobRecordAttachments') as $file) {
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/job_records'), $fileName);
                $attachmentPaths[] = 'uploads/job_records/' . $fileName;
            }
        }

        if ($jobRecord) {
            $jobRecord->update([
                'jobRecordCompletionDate' => $request->jobRecordCompletionDate,
                'jobRecordTotalCost'      => $request->jobRecordTotalCost,
                'jobRecordNotes'          => $request->jobRecordNotes,
                'jobRecordAttachments'    => $attachmentPaths,
            ]);
            $isNew = false;
            $msg = 'Job record updated successfully!';
        } else {
            $jobRecord = JobRecord::create([
                'bookingID'               => $request->bookingID,
                'staffID'                 => $staff->staffID,
                'jobRecordCompletionDate' => $request->jobRecordCompletionDate,
                'jobRecordTotalCost'      => $request->jobRecordTotalCost,
                'jobRecordNotes'          => $request->jobRecordNotes,
                'jobRecordAttachments'    => $attachmentPaths,
            ]);
            $isNew = true;
            $msg = 'Job record saved successfully!';
        }

        $booking = Booking::with('customer')->find($request->bookingID);
        if ($booking && $booking->customer) {
            $notificationMsg = $isNew
                ? "A job report has been added to your booking #{$booking->bookingID}."
                : "A job report has been updated for your booking #{$booking->bookingID}.";
            $booking->customer->notify(new \App\Notifications\RecentActivityNotification($notificationMsg));
        }

        $emailError = null;
        $emailSentSuccessfully = false;
        if ($request->boolean('send_invoice_email')) {
            try {
                \App\Http\Controllers\Invoice\InvoiceController::sendInvoiceEmail($booking, $jobRecord);
                $emailSentSuccessfully = true;
            } catch (\Exception $e) {
                $emailError = $e->getMessage();
            }
        }

        if ($emailError) {
            return redirect()->route('staff.job-records')
                ->with('success', $msg)
                ->withErrors(['email' => "Job record saved, but invoice email failed to send: {$emailError}"]);
        }

        if ($emailSentSuccessfully) {
            $msg .= ' PDF Invoice has been sent to customer email.';
        }

        return redirect()->route('staff.job-records')->with('success', $msg);
    }

    public function jobRecordPrint($id)
    {
        $staff = $this->staff();
        
        $jobRecord = JobRecord::with(['booking.customer', 'booking.staff'])
            ->where('jobRecordID', $id)
            ->firstOrFail();

        if (!$staff->isAdmin() && $jobRecord->staffID != $staff->staffID) {
            abort(403, 'Unauthorized action. You do not have permission to access this report.');
        }

        return view('staff.job-record-print', compact('staff', 'jobRecord'));
    }

    /* ─────────────────── FEEDBACK ─────────────────── */

    public function feedback()
    {
        $staff       = $this->staff();
        $allFeedback = Feedback::with(['customer', 'booking'])->orderByDesc('created_at')->get();
        $avgRating   = $allFeedback->avg('feedbackRating') ?? 0.0;

        return view('staff.feedback', compact('staff', 'allFeedback', 'avgRating'));
    }

    public function feedbackReply(Request $request, $feedbackID)
    {
        $request->validate([
            'staffResponse' => ['required', 'string', 'max:2000'],
        ]);

        $feedback = Feedback::findOrFail($feedbackID);
        $feedback->update([
            'staffResponse' => $request->staffResponse,
        ]);

        return redirect()->route('staff.feedback')->with('success', 'Your reply has been posted successfully!');
    }

    /* ─────────────────── LOGOUT ─────────────────── */

    public function logout(Request $request)
    {
        Auth::guard('staff')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
