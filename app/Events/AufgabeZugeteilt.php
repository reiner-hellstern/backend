<?php

namespace App\Events;

use App\Helpers\BroadcastHelper;
use App\Models\Aufgabe;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Aufgabe Zugeteilt Event
 *
 * Benachrichtigt einen User wenn eine Aufgabe zugewiesen wurde
 *
 * Usage:
 * $user = User::find($userId);
 * $aufgabe = Aufgabe::find($aufgabeId);
 * broadcast(new AufgabeZugeteilt($user, $aufgabe));
 */
class AufgabeZugeteilt implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;

    public $aufgabe;

    /**
     * Neue Event-Instanz erstellen.
     */
    public function __construct(User $user, Aufgabe $aufgabe)
    {
        $this->user = $user;
        $this->aufgabe = $aufgabe;
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
        return 'AufgabeZugeteilt';
    }

    /**
     * Gibt die Daten zurück, die gesendet werden sollen.
     * Sendet das komplette Model, damit es direkt im userDataStore verwendet werden kann.
     */
    public function broadcastWith(): array
    {
        return [
            'aufgabe' => $this->aufgabe->toArray(),
        ];
    }
}
