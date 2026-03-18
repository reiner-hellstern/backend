<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;

class UpdateLastLoginTime
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        // Update the lastlogin_at field for the authenticated user
        $event->user->update([
            'lastlogin_at' => now(),
        ]);
    }
}
