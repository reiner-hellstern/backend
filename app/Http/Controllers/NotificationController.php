<?php

namespace App\Http\Controllers;

use App\Events\SendNotification;
use App\Http\Requests\StoreNotificationRequest;
use App\Http\Requests\UpdateNotificationRequest;
use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notifications = Notification::latest()->get();

        return response()->json([
            'success' => 'Notifications erfolgreich geladen',
            'data' => NotificationResource::collection($notifications),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNotificationRequest $request)
    {
        $notification = Notification::create([
            'message' => $request->message,
            'receiver_id' => $request->receiver_id,
            'path' => $request->path,
            'pathname' => $request->pathname,
        ]);

        broadcast(new SendNotification($notification));

        return response()->json([
            'success' => 'Notification erfolgreich erstellt',
            'data' => new NotificationResource($notification),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Notification $notification)
    {
        return response()->json([
            'success' => 'Notification erfolgreich geladen',
            'data' => new NotificationResource($notification),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNotificationRequest $request, Notification $notification)
    {
        $notification->update($request->validated());

        return response()->json([
            'success' => 'Notification erfolgreich aktualisiert',
            'data' => new NotificationResource($notification),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notification $notification)
    {
        //
    }

    /**
     * Set notification as read (set read_at to now)
     */
    public function markRead(Request $request, Notification $notification)
    {
        $notification->read_at = now();
        $notification->save();

        return response()->json([
            'success' => 'Notification als gelesen markiert',
            'data' => $notification,
        ]);
    }
}
