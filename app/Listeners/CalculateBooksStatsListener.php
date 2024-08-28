<?php

namespace App\Listeners;

use App\Events\BooksImportedEvent;
use App\Jobs\CreateBookStatsJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CalculateBooksStatsListener
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
    public function handle(BooksImportedEvent $event): void
    {
        CreateBookStatsJob::dispatch($event->user);
    }
}
