<?php

namespace App\Events;

use App\Helpers\BroadcastHelper;
use App\Models\Rechnung;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Rechnung Erstellt Event
 *
 * Benachrichtigt einen User wenn eine neue Rechnung erstellt wurde
 *
 * Usage:
 * $user = User::find($userId);
 * $rechnung = Rechnung::find($rechnungId);
 * broadcast(new RechnungErstellt($user, $rechnung));
 */
class RechnungErstellt implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;

    public $rechnung;

    /**
     * ERstelle eine neue Event-Instanz.
     */
    public function __construct(User $user, Rechnung $rechnung)
    {
        $this->user = $user;
        $this->rechnung = $rechnung;
    }

    /**
     * Gibt die Kanäle zurück, auf denen das Event gesendet werden soll.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        $channelName = BroadcastHelper::getUserChannel($this->user->id);

        return [
            new PrivateChannel($channelName),
        ];
    }

    /**
     * Der Broadcast-Name des Events.
     */
    public function broadcastAs(): string
    {
        return 'RechnungErstellt';
    }

    /**
     * Gibt die Daten zurück, die gesendet werden sollen.
     * Sendet das komplette Model, damit es direkt im userDataStore verwendet werden kann.
     */
    public function broadcastWith(): array
    {
        return [
            'rechnung' => $this->rechnung->toArray(),
        ];
    }
}
