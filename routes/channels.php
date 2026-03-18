<?php

use App\Helpers\BroadcastHelper;
use Illuminate\Support\Facades\Broadcast;

/**
 * User Channel - Private channel for personal events
 * Each user can only subscribe to their own channel
 */
Broadcast::channel(BroadcastHelper::getInstanceId() . '.user.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});

/**
 * Notifications Channel (Legacy - kann später entfernt werden)
 * Each user can only subscribe to their own notifications
 */
Broadcast::channel(BroadcastHelper::getInstanceId() . '.notifications.{userId}', function ($user, $userId) {
    return (int) $user->id === (int) $userId;
});

/**
 * Role Channel - Private channel for role-based group messages
 * Users can only subscribe if they have the specified role
 */
Broadcast::channel(BroadcastHelper::getInstanceId() . '.role.{roleId}', function ($user, $roleId) {
    // Check if user has the role
    return $user->roles()->where('id', $roleId)->exists();

    // Alternative if you have a hasRole method:
    // return $user->hasRole($roleId);
});

/**
 * Organization Channel - Private channel for organization members
 * Users can only subscribe if they belong to the organization
 */
Broadcast::channel(BroadcastHelper::getInstanceId() . '.organization.{orgId}', function ($user, $orgId) {
    // Check if user belongs to organization
    return $user->organizations()->where('id', $orgId)->exists();

    // Alternative:
    // return $user->belongsToOrganization($orgId);
});

/**
 * App Channel - Public channel for global announcements
 * All authenticated users can subscribe
 * Note: This uses 'channel' not 'private' to be public
 */
// Broadcast::channel(BroadcastHelper::getInstanceId() . '.app', function ($user) {
//     return true; // All authenticated users
// });
