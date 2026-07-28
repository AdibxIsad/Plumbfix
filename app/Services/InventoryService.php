<?php

namespace App\Services;

use App\Models\Booking;
use Illuminate\Support\Facades\Log;

class InventoryService
{
    /**
     * Simulate ingredient/parts deduction based on booking service type.
     *
     * @param Booking $booking
     * @return bool
     */
    public static function deductIngredients(Booking $booking): bool
    {
        // Plumbfix is a plumbing service booking system and doesn't have physical ingredients.
        // We simulate parts and tool inventory check and deduction for the selected booking type.
        $serviceType = $booking->bookingType;
        
        Log::info("Simulating inventory deduction for Booking #{$booking->bookingID}. Service Type: {$serviceType}");

        // Simulate successful check/deduction
        switch ($serviceType) {
            case 'Pipe Repair':
                Log::info("Deducted: 1x PVC Pipe 1.5 inch, 2x Pipe Connectors, 1x Reseal Thread Tape");
                break;
            case 'Drain Cleaning':
                Log::info("Deducted: 500ml Drain Cleaner solution, 1x Rubber Gasket");
                break;
            case 'Leak Detection':
                Log::info("Checked out equipment: Ultrasonic Leak Detector, Thermal Camera");
                break;
            case 'Water Heater':
                Log::info("Deducted: 1x Heater Element, 1x Pressure Relief Valve");
                break;
            case 'Toilet Repair':
                Log::info("Deducted: 1x Flush Valve Kit, 1x Wax Ring Seal");
                break;
            case 'Tap & Faucet':
                Log::info("Deducted: 2x Tap Washers, 1x Ceramic Disc Cartridge");
                break;
            case 'Water Tank':
                Log::info("Deducted: 1x Ball Float Valve, 1x Overflow Pipe Fitting");
                break;
            default:
                Log::info("Checked out general plumbing toolbox and basic consumables.");
                break;
        }

        return true;
    }
}
