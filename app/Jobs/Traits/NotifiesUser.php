<?php

namespace App\Jobs\Traits;

use App\Facades\Notify;

trait NotifiesUser
{
    protected function notifyUser(string $message, bool $reload = false): void
    {
        // Notify the user
        Notify::realtime()->to($this->user)->success(
            $message,
            options: [
                'reload' => $reload
            ]
        );
    }


    protected function notifyUserError(string $message, bool $reload = false): void
    {
        // Notify the user
        Notify::realtime()->to($this->user)->danger(
            $message,
            options: [
                'reload' => $reload
            ]
        );
    }
}
