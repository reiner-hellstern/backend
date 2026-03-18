<?php

use App\Events\SendNotification;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Event;

use function Pest\Laravel\actingAs;

beforeEach(function () {
    // Events faken, da echter Reverb-Server für Tests nicht nötig ist
    Event::fake([SendNotification::class]);
});

test('notification can be created and broadcast via reverb', function () {
    $user = User::factory()->create();

    // Notification über die API erstellen
    $response = actingAs($user)
        ->postJson('/api/notification', [
            'message' => 'Test Notification via Reverb',
            'receiver_id' => $user->id,
            'path' => '/dashboard',
            'pathname' => 'Dashboard',
        ]);

    $response->assertStatus(201);
    $response->assertJson([
        'success' => 'Notification erfolgreich erstellt',
    ]);

    // Notification wurde in Datenbank gespeichert
    $this->assertDatabaseHas('notifications', [
        'message' => 'Test Notification via Reverb',
        'receiver_id' => $user->id,
    ]);

    // SendNotification Event wurde gefeuert (würde über Reverb gesendet)
    Event::assertDispatched(SendNotification::class, function ($event) {
        return $event->message === 'Test Notification via Reverb';
    });
});

test('notification can be marked as read', function () {
    $user = User::factory()->create();

    $notification = Notification::create([
        'message' => 'Unread notification',
        'receiver_id' => $user->id,
        'path' => '/test',
        'pathname' => 'Test',
    ]);

    // read_at ist initial leer (aufgrund des Casters im Model)
    expect($notification->read_at)->toBe('');

    // Als gelesen markieren
    $response = actingAs($user)
        ->postJson("/api/notification/{$notification->id}/mark-read");

    $response->assertOk();
    $response->assertJson([
        'success' => 'Notification als gelesen markiert',
    ]);

    $notification->refresh();
    // Nach dem Markieren sollte read_at ein Datum enthalten
    expect($notification->read_at)->not->toBe('');
});

test('multiple notifications can be sent to different users', function () {
    $users = User::factory()->count(3)->create();

    foreach ($users as $user) {
        $response = actingAs($user)
            ->postJson('/api/notification', [
                'message' => "Notification für {$user->name}",
                'receiver_id' => $user->id,
                'path' => '/profile',
                'pathname' => 'Profil',
            ]);

        $response->assertStatus(201);
    }

    // 3 Notifications in DB
    expect(Notification::count())->toBe(3);

    // 3 Events gefeuert
    Event::assertDispatched(SendNotification::class, 3);
});

test('notification contains correct structure for frontend', function () {
    $user = User::factory()->create();

    $response = actingAs($user)
        ->postJson('/api/notification', [
            'message' => 'Strukturierte Notification',
            'receiver_id' => $user->id,
            'path' => '/pruefungen/123',
            'pathname' => 'Prüfung Details',
        ]);

    $response->assertStatus(201);

    $notification = Notification::latest()->first();

    expect($notification->message)->toBe('Strukturierte Notification');
    expect($notification->receiver_id)->toBe($user->id);
    expect($notification->path)->toBe('/pruefungen/123');
    expect($notification->pathname)->toBe('Prüfung Details');
});

test('notification list can be retrieved', function () {
    $user = User::factory()->create();

    // 5 Notifications erstellen
    Notification::factory()->count(5)->create([
        'receiver_id' => $user->id,
    ]);

    $response = actingAs($user)
        ->postJson('/api/notifications');

    $response->assertOk();
    $response->assertJson([
        'success' => 'Notifications erfolgreich geladen',
    ]);

    expect($response->json('data'))->toHaveCount(5);
});

test('notification event broadcasts on correct channel', function () {
    $notification = Notification::factory()->create([
        'message' => 'Channel Test',
    ]);

    $event = new SendNotification($notification);

    // Event hat die richtige Message
    expect($event->message)->toBe('Channel Test');

    // Prüfe, dass Event broadcastOn() den 'notifications' Channel nutzt
    $channels = $event->broadcastOn();
    expect($channels)->toHaveCount(1);
    expect($channels[0]->name)->toBe('notifications');
});

test('notification can be updated', function () {
    $user = User::factory()->create();

    $notification = Notification::create([
        'message' => 'Original Message',
        'receiver_id' => $user->id,
        'path' => '/test',
        'pathname' => 'Test',
    ]);

    $response = actingAs($user)
        ->putJson("/api/notification/{$notification->id}", [
            'message' => 'Updated Message',
            'receiver_id' => $user->id,
            'path' => '/updated',
            'pathname' => 'Updated',
        ]);

    $response->assertOk();

    $notification->refresh();
    expect($notification->message)->toBe('Updated Message');
    expect($notification->path)->toBe('/updated');
});

test('notification can link to different paths', function () {
    $user = User::factory()->create();

    $paths = [
        '/hunde/456' => 'Hund Details',
        '/pruefungen/789' => 'Prüfung Übersicht',
        '/aufgaben/101' => 'Aufgabe anzeigen',
    ];

    foreach ($paths as $path => $pathname) {
        $response = actingAs($user)
            ->postJson('/api/notification', [
                'message' => "Notification für {$pathname}",
                'receiver_id' => $user->id,
                'path' => $path,
                'pathname' => $pathname,
            ]);

        $response->assertStatus(201);
    }

    expect(Notification::count())->toBe(3);

    $notifications = Notification::all();
    expect($notifications->pluck('path')->unique())->toHaveCount(3);
});
