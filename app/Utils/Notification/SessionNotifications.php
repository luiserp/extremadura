<?php

namespace App\Utils\Notification;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class SessionNotifications extends AbstractNotifications
{
    public function __invoke($type, $arguments)
    {
        $notifications = Session::get('notifications', []);

        Session::flash('notifications', [
            ...$notifications,
            [
                'type' => $type, 'message' => $arguments[0], 'key' => (string) Str::uuid(), 'duration' => $arguments[1] ?? 5000
            ],
        ]);
    }
}
