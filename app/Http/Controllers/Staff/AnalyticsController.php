<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnalyticsController extends Controller
{
    private function staff()
    {
        return Auth::guard('staff')->user();
    }

    public function index(Request $request)
    {
        $staff = $this->staff();

        // 1. Get available years in the database for filtering
        $years = Booking::selectRaw('YEAR(bookingDate) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        // Default to the latest year with data, or current year
        if (empty($years)) {
            $years = [date('Y')];
        }
        $selectedYear = (int)$request->input('year', $years[0]);

        // 2. Fetch all bookings for the selected year
        $bookings = Booking::whereYear('bookingDate', $selectedYear)->get();
        $totalBookings = $bookings->count();

        // 3. Initialize monthly data (Jan to Dec)
        $months = [
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
        ];

        $monthlyBookings = array_fill(1, 12, 0);
        $monthlyCompleted = array_fill(1, 12, 0);
        $monthlyCancelled = array_fill(1, 12, 0);

        foreach ($bookings as $booking) {
            $month = (int)$booking->bookingDate->format('m');
            $monthlyBookings[$month]++;
            if ($booking->bookingStatus === 'completed') {
                $monthlyCompleted[$month]++;
            } elseif ($booking->bookingStatus === 'cancelled') {
                $monthlyCancelled[$month]++;
            }
        }

        // 4. Rainy vs Dry Season Calculations
        // Rainy Season (Monsoon Period): Nov (11) to Mar (3)
        // Dry Season: Apr (4) to Oct (10)
        $rainyMonths = [11, 12, 1, 2, 3];
        $dryMonths = [4, 5, 6, 7, 8, 9, 10];

        $rainyTotal = 0;
        $dryTotal = 0;

        foreach ($rainyMonths as $m) {
            $rainyTotal += $monthlyBookings[$m];
        }
        foreach ($dryMonths as $m) {
            $dryTotal += $monthlyBookings[$m];
        }

        $rainyAverage = $rainyTotal / count($rainyMonths);
        $dryAverage = $dryTotal / count($dryMonths);

        // Surge index (%)
        $seasonalSurge = 0;
        if ($dryAverage > 0) {
            $seasonalSurge = (($rainyAverage - $dryAverage) / $dryAverage) * 100;
        }

        // Peak month determination
        $peakMonthNum = 1;
        $peakCount = -1;
        foreach ($monthlyBookings as $m => $count) {
            if ($count > $peakCount) {
                $peakCount = $count;
                $peakMonthNum = $m;
            }
        }
        $peakMonthName = $months[$peakMonthNum];

        // 5. Booking type distribution (overall and seasonal)
        $serviceTypes = [
            'Pipe Repair', 'Drain Cleaning', 'Leak Detection',
            'Water Heater', 'Toilet Repair', 'Tap & Faucet',
            'Water Tank', 'General Inspection'
        ];

        $overallTypeCounts = array_fill_keys($serviceTypes, 0);
        $rainyTypeCounts = array_fill_keys($serviceTypes, 0);
        $dryTypeCounts = array_fill_keys($serviceTypes, 0);

        foreach ($bookings as $booking) {
            $type = $booking->bookingType;
            if (isset($overallTypeCounts[$type])) {
                $overallTypeCounts[$type]++;
                $month = (int)$booking->bookingDate->format('m');
                if (in_array($month, $rainyMonths)) {
                    $rainyTypeCounts[$type]++;
                } else {
                    $dryTypeCounts[$type]++;
                }
            }
        }

        // Sort overall types desc
        arsort($overallTypeCounts);

        // 6. Detailed service spikes and resource recommendations
        $recommendations = [];
        $mostSurgedService = 'None';
        $highestSurgeVal = -1;

        foreach ($serviceTypes as $type) {
            $rCount = $rainyTypeCounts[$type];
            $dCount = $dryTypeCounts[$type];

            // Calculate monthly average for each season
            $rAvg = $rCount / count($rainyMonths);
            $dAvg = $dCount / count($dryMonths);

            $serviceSurge = 0;
            if ($dAvg > 0) {
                $serviceSurge = (($rAvg - $dAvg) / $dAvg) * 100;
            } elseif ($rAvg > 0) {
                $serviceSurge = 100; // Baseline surge if dry has 0
            }

            if ($serviceSurge > $highestSurgeVal) {
                $highestSurgeVal = $serviceSurge;
                $mostSurgedService = $type;
            }

            // Generate recommendation if surge is significant (>20%) and there is real demand
            if ($serviceSurge > 20 && $rCount > 3) {
                $plumbersNeeded = ceil($rAvg / 3); // Assume 1 plumber can handle 3 calls/month of this type comfortably
                $recommendations[] = [
                    'service' => $type,
                    'surge' => round($serviceSurge, 1),
                    'average_rainy' => round($rAvg, 1),
                    'average_dry' => round($dAvg, 1),
                    'plumbers_suggested' => $plumbersNeeded,
                    'text' => "Demand for **{$type}** surges by **" . round($serviceSurge, 0) . "%** during the wet season. Allocate at least **{$plumbersNeeded} technician(s)** exclusively for this category to avoid delays."
                ];
            }
        }

        // Overall general recommendations
        $generalRecs = [];
        if ($seasonalSurge > 0) {
            $totalPlumbers = Staff::count();
            $suggestedIncrease = ceil($totalPlumbers * ($seasonalSurge / 100));
            $generalRecs[] = "Overall booking demand increases by **" . round($seasonalSurge, 0) . "%** during the heavy monsoon season. We recommend scheduling **{$suggestedIncrease} extra technician(s)** or on-call shifts from November to March.";
        }
        $generalRecs[] = "Peak service demands occur in **{$peakMonthName}** with **{$peakCount} bookings**. Restrict staff annual leave approvals during this high-intensity month.";
        $generalRecs[] = "Water Heater and Toilet Repair remain stable year-round; shift preventive maintenance schedules to the dry season (April–October) to balance the workload.";

        // Calculate dynamic heights/percentages for CSS charts
        $maxMonthlyBookings = max($monthlyBookings);
        $maxMonthlyBookings = $maxMonthlyBookings > 0 ? $maxMonthlyBookings : 10;
        
        $chartData = [];
        for ($m = 1; $m <= 12; $m++) {
            $count = $monthlyBookings[$m];
            $chartData[$m] = [
                'name' => substr($months[$m], 0, 3),
                'full_name' => $months[$m],
                'count' => $count,
                'is_rainy' => in_array($m, $rainyMonths),
                'height_pct' => ($count / $maxMonthlyBookings) * 100,
                'completed' => $monthlyCompleted[$m],
                'cancelled' => $monthlyCancelled[$m],
            ];
        }

        return view('staff.analytics', compact(
            'staff',
            'years',
            'selectedYear',
            'totalBookings',
            'rainyTotal',
            'dryTotal',
            'rainyAverage',
            'dryAverage',
            'seasonalSurge',
            'peakMonthName',
            'peakCount',
            'overallTypeCounts',
            'rainyTypeCounts',
            'dryTypeCounts',
            'recommendations',
            'generalRecs',
            'chartData',
            'mostSurgedService',
            'highestSurgeVal'
        ));
    }
}
