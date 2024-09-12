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
use Modules\Comfyui\app\Services\ComfyUIService;
use Illuminate\Support\Str;

class BookGenerateImageJob implements ShouldQueue
{
    use Queueable, NotifiesUser;

    protected ComfyUIService $comfyUIService;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected $books,
        protected $user,
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->comfyUIService = resolve(ComfyUIService::class);

        try {

            for ($i = 0; $i < count($this->books); $i++) {

                $book = $this->books[$i];
                $title = $book->title;
                $text = $book->bookDescription()->first()->description ?? $book->description;

                $paths = $this->comfyUIService->generateImage($text);
                $name = Str::slug($title) . '.jpg';

                Log::info('Generated image for book: ', [
                    'book_id' => $book->id,
                    'image' => $paths[0],
                ]);

                $path = storage_path("app/public/comf/images/") . $paths[0];

                // Delete previous image
                $book->clearMediaCollection('books');
                // Save image
                $book->addMedia($path)
                    ->usingFileName($name)
                    ->toMediaCollection('books');
            }

            $this->notifyUser(trans('book.book_generate_image_success'), true);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            $this->notifyUserError(trans('book.book_generate_image_error'));

        }
    }
}
