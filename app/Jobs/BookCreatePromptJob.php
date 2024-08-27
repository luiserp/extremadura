<?php

namespace App\Jobs;

use App\Jobs\Traits\NotifiesUser;
use App\Models\Books\Book;
use App\Services\NLPApiService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class BookCreatePromptJob implements ShouldQueue
{
    use Queueable, NotifiesUser;

    protected NLPApiService $nlpApiService;

    /**
     * Create a new job instance.
     * @param $user
     * @param array|Collection<Book> $books
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
            $this->nlpApiService->generateDescription($this->books);

            $this->notifyUser(trans('book.book_create_prompt_success'), true);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            $this->notifyUserError(trans('book.book_create_prompt_error'));

        }
    }
}
