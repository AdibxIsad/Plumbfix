<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAsRead()
    {
        $user = auth('customer')->user() ?? auth('staff')->user();
        if ($user) {
            $user->unreadNotifications->markAsRead();
        }
        
        return back();
    }

    public function getUnreadNotifications()
    {
        $user = auth('customer')->user() ?? auth('staff')->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $unreadNotifications = $user->unreadNotifications;

        return response()->json([
            'unread_count' => $unreadNotifications->count(),
            'notifications' => $unreadNotifications->take(5)->map(function ($notif) {
                return [
                    'id' => $notif->id,
                    'message' => $notif->data['message'] ?? 'New activity',
                    'time_formatted' => $notif->created_at->diffForHumans(),
                ];
            })
        ]);
    }
}
