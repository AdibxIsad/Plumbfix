<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('login');
    }

    /**
     * Handle an authentication attempt for customers.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');

        // First, attempt customer login
        $customerCredentials = [
            'customerEmail'    => $request->email,
            'password'         => $request->password,
        ];

        if (Auth::guard('customer')->attempt($customerCredentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard')->with('welcome', 'Welcome back, ' . Auth::guard('customer')->user()->customerName . '! You have successfully logged into your account.');
        }

        // Next, attempt staff login
        $staffCredentials = [
            'staffEmail'    => $request->email,
            'password'      => $request->password,
        ];

        if (Auth::guard('staff')->attempt($staffCredentials, $remember)) {
            $request->session()->regenerate();
            $staff = Auth::guard('staff')->user();
            $role = $staff->isAdmin() ? 'Administrator' : 'Staff';
            return redirect()->route('staff.dashboard')->with('welcome', "Welcome back, {$role} {$staff->staffName}! You have successfully logged into your account.");
        }

        return back()
            ->withErrors(['email' => 'These credentials do not match our records.'])
            ->onlyInput('email');
    }

    /**
     * Log the customer out.
     */
    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
