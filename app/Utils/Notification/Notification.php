<?php

namespace App\Utils\Notification;

class Notification
{
    public function __call($name, $arguments)
    {
        return $this->session()->$name(...$arguments);
    }

    public function session()
    {
        return new SessionNotifications();
    }

    public function realtime()
    {
        return new RealtimeNotifications();
    }
}
