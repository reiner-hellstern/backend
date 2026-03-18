<?php

namespace App\Events;

use App\Helpers\BroadcastHelper;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SendNotification implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notification;

    /**
     * Create instance.
     */
    public function __construct($notification)
    {
        $this->notification = $notification;
    }

    /**
     * Get data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->notification->id,
            'message' => $this->notification->message,
            'receiver_id' => $this->notification->receiver_id,
            'sender_id' => $this->notification->sender_id,
            'role_id' => $this->notification->role_id,
            'path' => $this->notification->path,
            'pathname' => $this->notification->pathname,
            'read_at' => $this->notification->read_at,
            'created_at' => $this->notification->created_at,
            'type' => $this->notification->type ?? 'info', // info, success, warning, error
        ];
    }

    /**
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        // Sende auf dem neuen user channel (empfohlen)
        $userChannel = new PrivateChannel(BroadcastHelper::getUserChannel($this->notification->receiver_id));

        return [
            $userChannel,
        ];
    }

    /**
     * Der Broadcast-Name des Events.
     */
    public function broadcastAs(): string
    {
        return 'SendNotification';
    }
}
