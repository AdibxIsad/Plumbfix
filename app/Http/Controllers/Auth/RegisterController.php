<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /**
     * Show the customer registration form.
     */
    public function showRegisterForm()
    {
        return view('register');
    }

    /**
     * Handle a new customer registration request.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:customers,customerEmail'],
            'phone'    => ['nullable', 'string', 'max:20'],
            'address'  => ['nullable', 'string', 'max:500'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $customer = Customer::create([
            'customerName'     => $request->name,
            'customerEmail'    => $request->email,
            'customerPhoneNo'  => $request->phone,
            'customerAddress'  => $request->address,
            'customerPassword' => Hash::make($request->password),
        ]);

        // Log the customer in using the customer guard
        Auth::guard('customer')->login($customer);

        return redirect('/dashboard')->with('welcome', 'Welcome, ' . $customer->customerName . '! Your account has been created and you have successfully logged in.');
    }
}
