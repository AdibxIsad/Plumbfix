<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
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
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
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

        return (new MailMessage)
            ->subject($subject)
            ->greeting("Hello {$recipientName},")
            ->line($this->message)
            ->action('View PlumbFix Dashboard', url('/dashboard'))
            ->line('Thank you for using PlumbFix Service!');
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
