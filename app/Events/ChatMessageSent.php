<?php

namespace App\Events;

use App\Models\ChatMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatMessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $chatMessage;

    /**
     * Create a new event instance.
     */
    public function __construct(ChatMessage $chatMessage)
    {
        $this->chatMessage = $chatMessage;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('booking.' . $this->chatMessage->bookingID),
        ];
    }

    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        // Determine sender name
        $senderName = 'Unknown';
        if ($this->chatMessage->sender_type === 'customer') {
            $senderName = $this->chatMessage->booking->customer->customerName ?? 'Customer';
        } else {
            $senderName = $this->chatMessage->booking->staff->staffName ?? 'Staff';
        }

        return [
            'id' => $this->chatMessage->chatMessageID,
            'sender_type' => $this->chatMessage->sender_type,
            'sender_id' => $this->chatMessage->sender_id,
            'sender_name' => $senderName,
            'message' => $this->chatMessage->message,
            'time_formatted' => $this->chatMessage->created_at->timezone('Asia/Kuala_Lumpur')->format('h:i A'),
            'created_at' => $this->chatMessage->created_at->toISOString(),
        ];
    }
}
