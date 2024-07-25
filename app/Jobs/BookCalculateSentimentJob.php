<?php

namespace App\Jobs;

use App\Facades\Notify;
use App\Models\User;
use App\Services\NLPApiService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class BookCalculateSentimentJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected NLPApiService $service;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected $books,
        protected ?User $user = null,
    ) {
        $this->service = resolve(NLPApiService::class);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->service->calculateSentiment($this->books);

        if ($this->user) {
            app()->setLocale($this->user->locale);
            Notify::realtime()
                ->to($this->user)
                ->success(trans('book.book_calculated_sentiment'), 5000, [
                    'link' => [
                        'reload' => true
                    ]
                ]);
        }
    }
}
