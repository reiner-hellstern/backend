<?php

namespace App\Events;

use App\Helpers\BroadcastHelper;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Role Announcement Event
 *
 * Sendet eine Nachricht an alle Benutzer mit einer bestimmten Rolle.
 *
 * Usage:
 * broadcast(new RoleNotification($roleId, [
 *     'title' => 'Wichtige Mitteilung',
 *     'message' => 'Neue Richtlinien verfügbar',
 *     'type' => 'info',
 *     'link' => '/dokumente/richtlinien'
 * ]));
 */
class RoleNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $roleId;

    public $title;

    public $message;

    public $type;

    public $link;

    public $createdAt;

    /**
     * Create a new event instance.
     */
    public function __construct(int $roleId, array $data)
    {
        $this->roleId = $roleId;
        $this->title = $data['title'] ?? 'Ankündigung';
        $this->message = $data['message'] ?? '';
        $this->type = $data['type'] ?? 'info'; // info, success, warning, error
        $this->link = $data['link'] ?? null;
        $this->createdAt = now()->format('d.m.Y H:i');
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        $channelName = BroadcastHelper::getRoleChannel($this->roleId);

        return [
            new PrivateChannel($channelName),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'RoleNotification';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'role_id' => $this->roleId,
            'title' => $this->title,
            'message' => $this->message,
            'type' => $this->type,
            'link' => $this->link,
            'created_at' => $this->createdAt,
        ];
    }
}
