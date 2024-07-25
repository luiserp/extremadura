<?php

namespace App\Console\Commands;

use App\Jobs\BookCalculateEmbeddingJob;
use App\Jobs\BookCalculateSentimentJob;
use App\Models\Books\Book;
use App\Models\Books\BookEmbedding;
use App\Models\Books\BookSentiment;
use App\Services\NLPApiService;
use Illuminate\Console\Command;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MakeBooksTitleNlp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:titles-nlp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Use NLP to get information from books titles.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $books = Book::all();

        for ($i = 0; $i < count($books); $i++) {

            $book = $books[$i];
            $title = $book->title;

            BookCalculateEmbeddingJob::dispatch($books);
            BookCalculateSentimentJob::dispatch($books);

            $this->info("Book $i: $title");
        }

    }
}
