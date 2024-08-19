<?php

namespace App\Utils\Notification;

use App\Notifications\RealtimeNotification;
use Illuminate\Support\Facades\Log;

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

        Log::info('RealtimeNotifications', ['type' => $type, 'arguments' => $arguments]);

        $message = $arguments[0] ?? $arguments['message'] ?? null;
        $duration = $arguments[1] ?? $arguments['duration'] ?? 5000;
        $options = $arguments[2] ?? $arguments['options'] ?? null;

        $this->notifiable->notify(new RealtimeNotification($message, $type, $duration, $options));
    }

    public function to($notifiable = null)
    {
        $this->notifiable = $notifiable;
        return $this;
    }
}
