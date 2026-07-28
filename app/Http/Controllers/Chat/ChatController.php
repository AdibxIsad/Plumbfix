<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Helper to verify chat access.
     */
    private function verifyChatAccess($bookingId, $guard)
    {
        $user = Auth::guard($guard)->user();
        if (!$user) {
            abort(401, 'Unauthenticated.');
        }

        $booking = Booking::findOrFail($bookingId);

        // Authorization checks
        if ($guard === 'customer' && $booking->customerID !== $user->customerID) {
            abort(403, 'Unauthorized action.');
        }
        if ($guard === 'staff') {
            if (!$user->isAdmin() && $booking->staffID !== null && $booking->staffID !== $user->staffID) {
                abort(403, 'Unauthorized action.');
            }
        }

        return [$booking, $user];
    }

    /**
     * Get chat messages for a booking.
     */
    public function getMessages($bookingId, Request $request)
    {
        $guard = $request->segment(1) === 'staff' ? 'staff' : 'customer';
        list($booking, $user) = $this->verifyChatAccess($bookingId, $guard);

        // Mark unread messages sent by the other party as read
        ChatMessage::where('bookingID', $bookingId)
            ->where('sender_type', '!=', $guard)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $messages = $booking->chatMessages()->get();

        return response()->json([
            'messages' => $messages->map(function ($msg) {
                // Determine sender name
                $senderName = 'Unknown';
                if ($msg->sender_type === 'customer') {
                    $senderName = $msg->booking->customer->customerName ?? 'Customer';
                } else {
                    $senderName = $msg->booking->staff->staffName ?? 'Staff';
                }

                return [
                    'id' => $msg->chatMessageID,
                    'sender_type' => $msg->sender_type,
                    'sender_id' => $msg->sender_id,
                    'sender_name' => $senderName,
                    'message' => $msg->message,
                    'is_read' => $msg->is_read,
                    'time_formatted' => $msg->created_at->timezone('Asia/Kuala_Lumpur')->format('h:i A'),
                    'created_at' => $msg->created_at->toISOString(),
                ];
            })
        ]);
    }

    /**
     * Get unread chat messages status for the current user.
     */
    public function getUnreadStatus(Request $request)
    {
        $guard = Auth::guard('staff')->check() ? 'staff' : (Auth::guard('customer')->check() ? 'customer' : null);
        if (!$guard) {
            return response()->json(['unread_count' => 0, 'unread_booking_ids' => []]);
        }

        $user = Auth::guard($guard)->user();

        if ($guard === 'customer') {
            $bookingIds = Booking::where('customerID', $user->customerID)->pluck('bookingID');
            $query = ChatMessage::whereIn('bookingID', $bookingIds)
                ->where('sender_type', 'staff')
                ->where('is_read', false);
        } else {
            $bookingIds = $user->isAdmin()
                ? Booking::pluck('bookingID')
                : Booking::where('staffID', $user->staffID)->pluck('bookingID');

            $query = ChatMessage::whereIn('bookingID', $bookingIds)
                ->where('sender_type', 'customer')
                ->where('is_read', false);
        }

        $unreadBookingIds = (clone $query)->distinct()->pluck('bookingID')->toArray();
        $unreadCount = (clone $query)->count();

        return response()->json([
            'unread_count' => $unreadCount,
            'unread_booking_ids' => $unreadBookingIds,
        ]);
    }

    /**
     * Send a new chat message.
     */
    public function sendMessage(Request $request, $bookingId)
    {
        $guard = $request->segment(1) === 'staff' ? 'staff' : 'customer';
        list($booking, $user) = $this->verifyChatAccess($bookingId, $guard);

        $request->validate([
            'message' => ['required', 'string', 'max:1000'],
        ]);

        $senderType = $guard;
        $senderId = $guard === 'customer' ? $user->customerID : $user->staffID;

        $msg = ChatMessage::create([
            'bookingID' => $bookingId,
            'sender_type' => $senderType,
            'sender_id' => $senderId,
            'message' => $request->message,
        ]);

        // Send database / email notification to the other party
        $recipient = $guard === 'customer' ? $booking->staff : $booking->customer;
        $notificationMsg = $guard === 'customer'
            ? "New chat message from Customer {$user->customerName} on booking #{$bookingId}: \"{$request->message}\""
            : "New chat message from Plumber {$user->staffName} on booking #{$bookingId}: \"{$request->message}\"";

        if ($recipient) {
            $recipient->notify(new \App\Notifications\RecentActivityNotification($notificationMsg));
        }

        // Trigger Laravel Broadcasting Event if Pusher is configured
        try {
            event(new \App\Events\ChatMessageSent($msg));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Broadcasting failed: " . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => [
                'id' => $msg->chatMessageID,
                'sender_type' => $msg->sender_type,
                'sender_id' => $msg->sender_id,
                'sender_name' => $guard === 'customer' ? $user->customerName : $user->staffName,
                'message' => $msg->message,
                'time_formatted' => $msg->created_at->timezone('Asia/Kuala_Lumpur')->format('h:i A'),
                'created_at' => $msg->created_at->toISOString(),
            ]
        ]);
    }
}
