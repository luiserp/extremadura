<?php

namespace App\Jobs;

use App\Jobs\Traits\NotifiesUser;
use App\Services\NLPApiService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class BookGenerateImageJob implements ShouldQueue
{
    use Queueable, NotifiesUser;

    protected NLPApiService $nlpApiService;


    /**
     * Create a new job instance.
     */
    public function __construct(
        protected $books,
        protected $user,
    )
    {
        $this->nlpApiService = resolve(NLPApiService::class);

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $this->nlpApiService->generateImage($this->books);

            $this->notifyUser(trans('book.book_generate_image_success'), true);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            $this->notifyUserError(trans('book.book_generate_image_error'));

        }
    }
}
