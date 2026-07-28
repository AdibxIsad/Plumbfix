<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    /**
     * Redirect the user to Google's OAuth page.
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle the callback from Google.
     * Finds or creates a Customer account, then logs them in.
     */
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Google sign-in failed. Please try again.']);
        }

        // Find existing customer by email
        $customer = Customer::where('customerEmail', $googleUser->getEmail())->first();

        if (!$customer) {
            // Auto-register a new customer account using Google profile data
            $customer = Customer::create([
                'customerName'     => $googleUser->getName(),
                'customerEmail'    => $googleUser->getEmail(),
                'customerPassword' => bcrypt(Str::random(24)), // Random secure password
            ]);
        }

        // Log in the customer via the 'customer' guard
        Auth::guard('customer')->login($customer, true);

        return redirect()->intended('/dashboard')->with('welcome', 'Welcome back, ' . $customer->customerName . '! You have successfully logged into your account.');
    }
}
