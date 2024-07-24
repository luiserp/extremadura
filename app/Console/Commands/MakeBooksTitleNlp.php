<?php

namespace App\Console\Commands;

use App\Models\Books\Book;
use App\Models\Books\BookEmbedding;
use App\Models\Books\BookSentiment;
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

            dispatch(function() use ($book, $title) {

                $responses = Http::pool(fn (Pool $pool) => [
                    $pool->post(config('services.nlp.url'). '/nlp', [
                        'text' => $title
                    ]),
                    $pool->post(config('services.nlp.url'). '/embeddings', [
                        'text' => $title
                    ]),
                ]);

                $nlp = $responses[0]->json();
                $embeddings = $responses[1]->json();

                $sentiment = collect($nlp['sentiment']);
                $positive = $sentiment->where('label', 'positive')->first()['score'];
                $negative = $sentiment->where('label', 'negative')->first()['score'];
                $neutral = $sentiment->where('label', 'neutral')->first()['score'];

                $g = $positive * 255;
                $r = $negative * 255;
                $b = $neutral * 255;

                $book->update([
                    'color' => "rgb($r, $g, $b)"
                ]);

                BookEmbedding::updateOrCreate([
                    'book_id' => $book->id,
                ], [
                    'embeddings_model' => $embeddings['model'],
                    'embeddings' => json_encode($embeddings['embeddings']),
                ]);

                BookSentiment::updateOrCreate([
                    'book_id' => $book->id,
                ], [
                    'sentiment_model' => $nlp['model'],
                    'positive_sentiment' => $positive,
                    'negative_sentiment' => $negative,
                    'neutral_sentiment' => $neutral,
                ]);
            });


            $this->info("Book $i: $title");
        }

    }
}
