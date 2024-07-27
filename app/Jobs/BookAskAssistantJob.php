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

class BookAskAssistantJob implements ShouldQueue
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

        try {

            $this->service->askAssistant($this->books);

            Log::info(app()->getLocale());

            if ($this->user) {
                app()->setLocale($this->user->locale);
                Notify::realtime()
                    ->to($this->user)
                    ->success('Data verified with assistant', 5000, [
                        'link' => [
                            'reload' => true
                        ]
                    ]);
            }

        } catch (\Exception $e) {

            if ($this->user) {
                app()->setLocale($this->user->locale);
                Notify::realtime()
                    ->to($this->user)
                    ->danger(trans($e->getMessage()), 5000, [
                        'link' => [
                            'reload' => true
                        ]
                    ]);
            }

        }
    }
}
