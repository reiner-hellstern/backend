<?php

namespace App\Http\Controllers\Examples;

use App\Events\AufgabeEntzogen;
use App\Events\AufgabeZugeteilt;
use App\Events\RechnungErstellt;
use App\Events\RoleNotification;
use App\Http\Controllers\Controller;
use App\Models\Aufgabe;
use App\Models\Rechnung;
use App\Models\Role;
use App\Models\User;
use App\Notifications\SendNotification;
use Illuminate\Http\Request;

/**
 * Beispiele für Realtime Events
 *
 * Diese Beispiele zeigen, wie man die verschiedenen Event-Types verwendet.
 * Alle Events senden komplette Models, damit sie direkt im Frontend Store verwendet werden können.
 */
class RealtimeExamplesController extends Controller
{
    /**
     * Example 1: Persönliche Notification senden
     * Verwendet den User Channel
     */
    public function sendPersonalNotification(Request $request)
    {
        $user = User::find($request->user_id);

        // Über Notification-System (empfohlen für einfache Benachrichtigungen)
        $user->notify(new SendNotification([
            'message' => $request->message ?? 'Du hast eine neue Nachricht',
            'path' => $request->path ?? '/dashboard',
            'pathname' => $request->pathname ?? 'Dashboard',
            'type' => $request->type ?? 'info',
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Notification gesendet',
        ]);
    }

    /**
     * Example 2: Aufgabe zuweisen
     * Sendet AufgabeZugeteilt Event mit komplettem Aufgabe-Model
     */
    public function assignTask(Request $request)
    {
        $user = User::find($request->user_id);

        // Aufgabe in DB speichern
        $aufgabe = Aufgabe::create([
            'name' => $request->name,
            'beschreibung' => $request->beschreibung,
            'faelligkeit' => $request->faelligkeit,
            'status_id' => $request->status_id ?? 1, // Standard: Offen
            'editor_id' => auth()->id(),
        ]);

        // Realtime Event senden - übergibt komplettes Model
        broadcast(new AufgabeZugeteilt($user, $aufgabe));

        return response()->json([
            'success' => true,
            'aufgabe' => $aufgabe,
            'message' => 'Aufgabe zugewiesen und Realtime-Notification gesendet',
        ]);
    }

    /**
     * Example 3: Aufgabe entziehen
     * Sendet AufgabeEntzogen Event wenn ein anderer User die Aufgabe übernimmt
     */
    public function reassignTask(Request $request)
    {
        $aufgabe = Aufgabe::findOrFail($request->aufgabe_id);
        $alterUser = User::findOrFail($request->alter_user_id);
        $neuerUser = User::findOrFail($request->neuer_user_id);

        // Aufgabe neu zuweisen
        $aufgabe->update([
            'editor_id' => $neuerUser->id,
        ]);

        // Realtime Event an alten User senden
        broadcast(new AufgabeEntzogen($alterUser, $neuerUser, $aufgabe));

        // Realtime Event an neuen User senden
        broadcast(new AufgabeZugeteilt($neuerUser, $aufgabe));

        return response()->json([
            'success' => true,
            'aufgabe' => $aufgabe,
            'message' => 'Aufgabe neu zugewiesen, beide User benachrichtigt',
        ]);
    }

    /**
     * Example 4: Rechnung erstellen
     * Sendet RechnungErstellt Event mit komplettem Rechnung-Model
     */
    public function createInvoice(Request $request)
    {
        $user = User::find($request->user_id);

        // Rechnung in DB erstellen
        $rechnung = Rechnung::create([
            'name' => $request->name ?? 'Neue Rechnung',
            'rechnungsnummer' => 'RE-' . now()->format('Y-m-d-His'),
            'rechnungssumme' => $request->rechnungssumme,
            'empfaenger_id' => $user->id,
            'rechnungsdatum' => now(),
            'faelligkeit' => now()->addDays(14),
            'bezahlstatus_id' => 1, // Offen
        ]);

        // Realtime Event senden - übergibt komplettes Model
        broadcast(new RechnungErstellt($user, $rechnung));

        return response()->json([
            'success' => true,
            'rechnung' => $rechnung,
            'message' => 'Rechnung erstellt und Realtime-Notification gesendet',
        ]);
    }

    /**
     * Example 5: Role Notification senden
     * Sendet Notification an alle Benutzer mit einer bestimmten Rolle
     */
    public function sendRoleNotification(Request $request)
    {
        // Role finden (z.B. "zuchtwart", "admin", "member")
        $role = Role::where('name', $request->role_name)->firstOrFail();

        // Wie viele User haben diese Role?
        $userCount = $role->users()->count();

        broadcast(new RoleNotification($role->id, [
            'title' => $request->title,
            'message' => $request->message,
            'type' => $request->type ?? 'info',
            'link' => $request->link ?? null,
        ]));

        return response()->json([
            'success' => true,
            'message' => "Ankündigung an {$userCount} User mit Role '{$role->name}' gesendet",
            'user_count' => $userCount,
        ]);
    }

    /**
     * Example 6: Sende an alle Geschäftsstellenmitarbeiter (häufiger Use Case)
     */
    public function notifyAllGeschaeftsstellenmitarbeiter(Request $request)
    {
        $role = Role::where('name', 'geschaeftsstelle')->first();

        if (! $role) {
            return response()->json([
                'error' => 'Role "geschaeftsstelle" nicht gefunden',
            ], 404);
        }

        broadcast(new RoleNotification($role->id, [
            'title' => 'Wichtig für alle Geschäftsstellenmitarbeiter',
            'message' => $request->message,
            'type' => 'warning',
            'link' => '/geschaeftsstelle/richtlinien',
        ]));

        $userCount = $role->users()->count();

        return response()->json([
            'success' => true,
            'message' => "Nachricht an {$userCount} Geschäftsstellenmitarbeiter gesendet",
        ]);
    }
}
