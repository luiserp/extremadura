<?php

namespace App\Jobs;

use App\Facades\Notify;
use App\Imports\Books\BookImport;
use App\Jobs\Traits\NotifiesUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class BookImportJob implements ShouldQueue
{
    use Queueable, NotifiesUser;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected $user,
        protected $filePath
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Import the file
            $filePath = $this->filePath;

            $file = storage_path('app/' . $filePath);

            Excel::import(new BookImport, $file);

            $this->notifyUser(trans('book.import_books_success'), true);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $this->notifyUserError(trans('book.delete_all_books_error'), true);
        }
    }
}
