<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class RecentActivityNotification extends Notification
{
    use Queueable;

    public $message;

    /**
     * Create a new notification instance.
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        $channels = ['database'];

        // Task 10: Dynamically add 'mail' channel for booking confirmed, completed, and invoice ready.
        if ($this->shouldSendEmail()) {
            $channels[] = 'mail';
        }

        return $channels;
    }

    /**
     * Determine if we should send an email notification.
     */
    protected function shouldSendEmail(): bool
    {
        $msg = strtolower($this->message);
        return str_contains($msg, 'confirmed') || 
               str_contains($msg, 'accepted') ||
               str_contains($msg, 'approved') ||
               str_contains($msg, 'deposit');
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable)
    {
        $subject = 'PlumbFix Notification';
        $msg = strtolower($this->message);
        if (str_contains($msg, 'deposit') || str_contains($msg, 'pay your deposit')) {
            $subject = 'Deposit Payment Request — PlumbFix';
        } elseif (str_contains($msg, 'confirmed') || str_contains($msg, 'accepted') || str_contains($msg, 'approved')) {
            $subject = 'Booking Confirmed — PlumbFix';
        } elseif (str_contains($msg, 'completed')) {
            $subject = 'Booking Completed — PlumbFix';
        } elseif (str_contains($msg, 'job report') || str_contains($msg, 'invoice')) {
            $subject = 'Invoice Ready — PlumbFix';
        }

        $recipientName = $notifiable->customerName ?? $notifiable->staffName ?? 'User';

        return (new \App\Mail\ActivityNotificationMail($recipientName, $this->message, $subject))
            ->to($notifiable->routeNotificationForMail($this));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => $this->message,
        ];
    }
}
