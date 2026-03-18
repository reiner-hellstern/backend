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
 * Aufgabe Entzogen Event
 *
 * Benachrichtigt einen User wenn eine Aufgabe ihm entzogen wurde,
 * weil ein anderer User die Aufgabe übernommen hat
 *
 * Usage:
 * $alterUser = User::find($alterUserId); // Der User, dem die Aufgabe entzogen wird
 * $neuerUser = User::find($neuerUserId); // Der User, der die Aufgabe übernommen hat
 * $aufgabe = Aufgabe::find($aufgabeId);
 * broadcast(new AufgabeEntzogen($alterUser, $neuerUser, $aufgabe));
 */
class AufgabeEntzogen implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $alterUser;

    public $neuerUser;

    public $aufgabe;

    /**
     * Erstelle eine neue Event-Instanz.
     */
    public function __construct(User $alterUser, User $neuerUser, Aufgabe $aufgabe)
    {
        $this->alterUser = $alterUser;
        $this->neuerUser = $neuerUser;
        $this->aufgabe = $aufgabe;
    }

    /**
     * Gibt die Kanäle zurück, auf denen das Event gesendet werden soll.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        $channelName = BroadcastHelper::getUserChannel($this->alterUser->id);

        return [
            new PrivateChannel($channelName),
        ];
    }

    /**
     * Der Broadcast-Name des Events.
     */
    public function broadcastAs(): string
    {
        return 'AufgabeEntzogen';
    }

    /**
     * Gibt die zu sendenden Daten zurück.
     * Sendet das komplette Model, damit es direkt im userDataStore verwendet werden kann.
     */
    public function broadcastWith(): array
    {
        return [
            'aufgabe' => $this->aufgabe->toArray(),
            'neuer_bearbeiter' => [
                'id' => $this->neuerUser->id,
                'name' => $this->neuerUser->name,
            ],
            'entzogen_am' => now()->format('d.m.Y H:i'),
        ];
    }
}
