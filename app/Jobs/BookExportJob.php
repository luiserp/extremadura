<?php

namespace App\Jobs;

use App\Exports\BookExport;
use App\Jobs\Traits\NotifiesUser;
use App\Mail\BookExportMail;
use App\Models\Books\Book;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class BookExportJob implements ShouldQueue
{
    use Queueable;
    use NotifiesUser;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected $user,
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {

            $catalogs = Book::select('catalog')->distinct()->pluck('catalog')->toArray();

            $excels = [];

            foreach ($catalogs as $catalog) {

                $pathToStore = "exports/{$this->user->id}/books_{$catalog}.csv";

                Excel::store(new BookExport($catalog), $pathToStore, 'public', null, [
                    'visibility' => 'public',
                ]);

                // Generate a link to the file (public)
                $booksLink = asset("storage/exports/{$this->user->id}/books_{$catalog}.csv");

                $excels[] = [
                    'catalog' => $catalog,
                    'link' => $booksLink,
                ];
            }

            Mail::to($this->user->email)->send(new BookExportMail($excels));

            $this->notifyUser(trans('book.export_books_success'), true);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $this->notifyUserError(trans('book.export_books_error'));
        }
    }
}
