<?php

namespace App\Utils\Notification;

use App\Notifications\RealtimeNotification;

class RealtimeNotifications extends AbstractNotifications
{
    protected $notifiable = null;

    /**
     * @param string $type
     * @param array $arguments
     *  @param string $arguments[0] message
     *  @param int $arguments[1] duration
     *  @param string|null $arguments[2] options
     * @throws \Exception
     */
    public function __invoke($type, $arguments)
    {
        $this->notifiable = $this->notifiable ?? auth()->user();

        if (!$this->notifiable) {
            throw new \Exception('No notifiable found in RealtimeNotifications');
        }

        $this->notifiable->notify(new RealtimeNotification($arguments[0], $type, $arguments[1] ?? 5000, $arguments[2] ?? null));
    }

    public function to($notifiable = null)
    {
        $this->notifiable = $notifiable;
        return $this;
    }
}
