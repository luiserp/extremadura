<?php

namespace App\Jobs;

use App\Jobs\Traits\NotifiesUser;
use App\Models\Books\Author;
use App\Models\Books\Book;
use App\Models\Books\BookEmbedding;
use App\Models\Books\BookSentiment;
use App\Models\Books\Category;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class BookDeleteAllJob implements ShouldQueue
{
    use Queueable, NotifiesUser;

    /**
     * Create a new job instance.
     */
    public function __construct(
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
        $allBooks = Book::all();

        foreach ($allBooks as $book) {
            $book->authors()->detach();
            $book->embedding()->delete();
            $book->sentiment()->delete();
            $book->category()->dissociate();
            $book->delete();
        }

        Author::whereDoesntHave('books')->delete();
        Category::whereDoesntHave('books')->delete();
        BookEmbedding::whereDoesntHave('book')->delete();
        BookSentiment::whereDoesntHave('book')->delete();

        $this->notifyUser(trans('book.delete_all_books_success'), true);

    }
}
