<?php

namespace App\Jobs;

use App\Jobs\Traits\NotifiesUser;
use App\Models\User;
use App\Services\Stats\BookStatsService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CreateBookStatsJob implements ShouldQueue
{
    use Queueable, NotifiesUser, Dispatchable, InteractsWithQueue, SerializesModels;

    protected BookStatsService $bookStatsService;
    /**
     * Create a new job instance.
     */
    public function __construct(
        protected User $user
    )
    {
        $this->bookStatsService = resolve(BookStatsService::class);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {

            $this->calculateStats();

            $this->notifyUser(trans('book.calculate_stats_success'), true);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $this->notifyUserError(trans('book.calculate_stats_error'), true);
        }
    }

    protected function calculateStats()
    {
        $this->bookStatsService->calculateCitiesStats();

        $this->bookStatsService->calculateAuthorsStats();

        $this->bookStatsService->calculateCategoryStats();

        $this->bookStatsService->calculateBooksByCityAndCategory();
    }
}
