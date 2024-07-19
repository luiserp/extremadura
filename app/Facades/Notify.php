<?php

namespace App\Facades;

use App\Utils\Notification\RealtimeNotifications;
use App\Utils\Notification\SessionNotifications;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void success($message, $duration = 5000, $options = null)
 * @method static void warning($message, $duration = 5000, $options = null)
 * @method static void danger($message, $duration = 5000, $options = null)
 * @method static void info($message, $duration = 5000, $options = null)
 * @method static RealtimeNotifications realtime()
 * @method static SessionNotifications session()

    * @see \App\Utils\Notification\Notification

 */
class Notify extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Notify';
    }
}
