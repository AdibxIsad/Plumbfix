<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\URL::forceScheme('https');

        \Illuminate\Support\Facades\Mail::extend('brevo-api', function (array $config) {
            return new \App\Mail\BrevoApiTransport($config['key'] ?? env('BREVO_API_KEY'));
        });

        // Share unread chat status across all Blade views
        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            $hasUnread = false;
            $guard = \Illuminate\Support\Facades\Auth::guard('staff')->check() ? 'staff' : (\Illuminate\Support\Facades\Auth::guard('customer')->check() ? 'customer' : null);
            if ($guard) {
                $user = \Illuminate\Support\Facades\Auth::guard($guard)->user();
                if ($guard === 'customer') {
                    $bookingIds = \App\Models\Booking::where('customerID', $user->customerID)->pluck('bookingID');
                    $hasUnread = \App\Models\ChatMessage::whereIn('bookingID', $bookingIds)
                        ->where('sender_type', 'staff')
                        ->where('is_read', false)
                        ->exists();
                } else {
                    $bookingIds = $user->isAdmin()
                        ? \App\Models\Booking::pluck('bookingID')
                        : \App\Models\Booking::where('staffID', $user->staffID)->pluck('bookingID');

                    $hasUnread = \App\Models\ChatMessage::whereIn('bookingID', $bookingIds)
                        ->where('sender_type', 'customer')
                        ->where('is_read', false)
                        ->exists();
                }
            }
            $view->with('hasChatMessages', $hasUnread);
        });
    }
}
