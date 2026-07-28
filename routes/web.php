<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Staff\StaffDashboardController;
use App\Http\Controllers\Customer\CustomerController;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\NotificationController;
Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
Route::get('/notifications/unread', [NotificationController::class, 'getUnreadNotifications'])->name('notifications.unread');

// ── Google OAuth Routes ───────────────────────────────────────────────────
Route::get('/auth/google',          [GoogleAuthController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');

Route::get('/test-login', function () {
    $success = \Illuminate\Support\Facades\Auth::guard('staff')->attempt(['staffEmail' => 'admin@gmail.com', 'password' => 'admin123']);
    return response()->json([
        'success' => $success,
        'user'    => \Illuminate\Support\Facades\Auth::guard('staff')->user(),
        'check'   => \Illuminate\Support\Facades\Auth::guard('staff')->check(),
        'session' => session()->all(),
    ]);
});

// ── Authentication Routes ─────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',    [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login',   [LoginController::class, 'login'])->name('login.post');

    Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
    Route::post('/register',[RegisterController::class, 'register'])->name('register.post');
});

// ── Customer Routes ───────────────────────────────────────────────────────
Route::middleware('auth:customer')->group(function () {

    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('dashboard');

    // Profile
    Route::get('/profile',         [CustomerController::class, 'profile'])->name('customer.profile');
    Route::post('/profile/update', [CustomerController::class, 'profileUpdate'])->name('customer.profile.update');

    // Bookings
    Route::get('/bookings/booked-slots', [CustomerController::class, 'getBookedSlots'])->name('customer.bookings.booked-slots');
    Route::get('/bookings',           [CustomerController::class, 'bookings'])->name('customer.bookings');
    Route::get('/bookings/create',    [CustomerController::class, 'bookingCreate'])->name('customer.booking.create');
    Route::post('/bookings/store',    [CustomerController::class, 'bookingStore'])->name('customer.booking.store');
    Route::get('/bookings/{id}/cancel', [CustomerController::class, 'confirmCancel'])->name('customer.booking.cancel.confirm');
    Route::post('/bookings/{id}/cancel', [CustomerController::class, 'bookingDelete'])->name('customer.booking.delete');
    
    // Invoice & Chat Routes
    Route::get('/bookings/{id}/invoice/download', [\App\Http\Controllers\Invoice\InvoiceController::class, 'download'])->name('customer.booking.invoice.download');
    Route::get('/bookings/{id}/chat/messages', [\App\Http\Controllers\Chat\ChatController::class, 'getMessages'])->name('customer.booking.chat.messages');
    Route::post('/bookings/{id}/chat/messages', [\App\Http\Controllers\Chat\ChatController::class, 'sendMessage'])->name('customer.booking.chat.messages.send');
    Route::get('/chat/unread-status', [\App\Http\Controllers\Chat\ChatController::class, 'getUnreadStatus'])->name('customer.chat.unread-status');

    // Payment Routes
    Route::get('/payment/{bookingID}', [\App\Http\Controllers\Customer\PaymentController::class, 'showPaymentPage'])->name('customer.payment.show');
    Route::post('/payment/{bookingID}/upload', [\App\Http\Controllers\Customer\PaymentController::class, 'uploadReceipt'])->name('customer.payment.upload');
    Route::get('/bookings/{id}/receipt/download', [\App\Http\Controllers\Customer\PaymentController::class, 'downloadReceipt'])->name('customer.booking.receipt.download');

    // Feedback
    Route::get('/feedback',           [CustomerController::class, 'feedback'])->name('customer.feedback');
    Route::post('/feedback/store',    [CustomerController::class, 'feedbackStore'])->name('customer.feedback.store');
});

// ── Staff Routes ──────────────────────────────────────────────────────────
Route::middleware('auth:staff')->prefix('staff')->group(function () {
    // Dashboard
    Route::get('/dashboard',  [\App\Http\Controllers\Staff\StaffController::class, 'dashboard'])->name('staff.dashboard');
    Route::get('/analytics',  [\App\Http\Controllers\Staff\AnalyticsController::class, 'index'])->name('staff.analytics');
    Route::post('/logout',    [\App\Http\Controllers\Staff\StaffController::class, 'logout'])->name('staff.logout');

    // Plumbers (Admin only)
    Route::get('/plumbers',           [\App\Http\Controllers\Staff\PlumberController::class, 'index'])->name('staff.plumbers');
    Route::post('/plumbers',          [\App\Http\Controllers\Staff\PlumberController::class, 'store'])->name('staff.plumbers.store');
    Route::put('/plumbers/{id}',      [\App\Http\Controllers\Staff\PlumberController::class, 'update'])->name('staff.plumbers.update');
    Route::delete('/plumbers/{id}',   [\App\Http\Controllers\Staff\PlumberController::class, 'destroy'])->name('staff.plumbers.destroy');

    // Profile
    Route::get('/profile',         [\App\Http\Controllers\Staff\StaffController::class, 'profile'])->name('staff.profile');
    Route::post('/profile/update', [\App\Http\Controllers\Staff\StaffController::class, 'profileUpdate'])->name('staff.profile.update');

    // Bookings
    Route::get('/bookings',                       [\App\Http\Controllers\Staff\StaffController::class, 'bookings'])->name('staff.bookings');
    Route::post('/bookings/{id}/status',          [\App\Http\Controllers\Staff\StaffController::class, 'bookingUpdateStatus'])->name('staff.booking.status');
    Route::post('/bookings/{id}/accept',          [\App\Http\Controllers\Staff\StaffController::class, 'bookingAccept'])->name('staff.booking.accept');

    // Invoice & Chat Routes
    Route::get('/bookings/{id}/invoice/download', [\App\Http\Controllers\Invoice\InvoiceController::class, 'download'])->name('staff.booking.invoice.download');
    Route::post('/bookings/{id}/invoice/send-email', [\App\Http\Controllers\Invoice\InvoiceController::class, 'sendEmail'])->name('staff.booking.invoice.send-email');
    Route::get('/bookings/{id}/chat/messages', [\App\Http\Controllers\Chat\ChatController::class, 'getMessages'])->name('staff.booking.chat.messages');
    Route::post('/bookings/{id}/chat/messages', [\App\Http\Controllers\Chat\ChatController::class, 'sendMessage'])->name('staff.booking.chat.messages.send');
    Route::get('/chat/unread-status', [\App\Http\Controllers\Chat\ChatController::class, 'getUnreadStatus'])->name('staff.chat.unread-status');

    // Job Records
    Route::get('/job-records',                    [\App\Http\Controllers\Staff\StaffController::class, 'jobRecords'])->name('staff.job-records');
    Route::get('/job-records/create/{bookingId}', [\App\Http\Controllers\Staff\StaffController::class, 'jobRecordCreate'])->name('staff.job-record.create');
    Route::post('/job-records/store',             [\App\Http\Controllers\Staff\StaffController::class, 'jobRecordStore'])->name('staff.job-record.store');
    Route::get('/job-records/{id}/print',         [\App\Http\Controllers\Staff\StaffController::class, 'jobRecordPrint'])->name('staff.job-record.print');

    Route::get('/feedback',                       [\App\Http\Controllers\Staff\StaffController::class, 'feedback'])->name('staff.feedback');
    Route::post('/feedback/{feedbackID}/reply',    [\App\Http\Controllers\Staff\StaffController::class, 'feedbackReply'])->name('staff.feedback.reply');

    // Payment Verification
    Route::get('/payment-verification', [\App\Http\Controllers\Staff\PaymentVerificationController::class, 'index'])->name('staff.payments.index');
    Route::get('/payment-verification-list', [\App\Http\Controllers\Staff\PaymentVerificationController::class, 'index'])->name('staff.payment-verification');
    Route::post('/payment-verification/{id}/approve', [\App\Http\Controllers\Staff\PaymentVerificationController::class, 'approve'])->name('staff.payments.approve');
    Route::post('/payment-verification/{id}/reject', [\App\Http\Controllers\Staff\PaymentVerificationController::class, 'reject'])->name('staff.payments.reject');
    Route::get('/bookings/{id}/receipt/download', [\App\Http\Controllers\Customer\PaymentController::class, 'downloadReceipt'])->name('staff.booking.receipt.download');

    // Refund Management
    Route::get('/refunds', [\App\Http\Controllers\Staff\RefundController::class, 'index'])->name('staff.refunds.index');
    Route::post('/refunds/{id}/complete', [\App\Http\Controllers\Staff\RefundController::class, 'markAsRefunded'])->name('staff.refunds.complete');
});
