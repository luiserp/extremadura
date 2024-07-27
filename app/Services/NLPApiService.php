<?php

namespace App\Services;

use App\Dtos\BookDto;
use App\Exceptions\Book\ErrorParsingDataCheckResponseExeption;
use App\Models\Books\BookEmbedding;
use App\Models\Books\BookSentiment;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NLPApiService
{
    /**
     * Calculate embeddings for books
     * @param array|Collection<BookDto> $books
     * @return void
     */
    public function askAssistant($books)
    {
        for ($i = 0; $i < count($books); $i++) {
            $book = $books[$i];
            $reference = $book->reference;

            $response = Http::timeout(320)->post(config('services.nlp.url'). '/data-checker', [
                'text' => $reference
            ]);

            $dataChecker = $response->json();

            try {

                $json = json_decode($dataChecker['data']['data'], true);

                if ($json) {
                    $book->update([
                        'year' => $json['year'],
                        'city' => $json['city'],
                        'editorial' => $json['editorial'],
                    ]);
                }

            } catch (\Exception $e) {
                // Handle exception
                Log::error($e->getMessage());
                throw new ErrorParsingDataCheckResponseExeption();
            }
        }
    }

    /**
     * Calculate embeddings for books
     * @param array|Collection<BookDto> $books
     * @return void
     */
    public function calculateEmbeddings($books)
    {
        for ($i = 0; $i < count($books); $i++) {
            $book = $books[$i];
            $title = $book->title;

            $response = Http::post(config('services.nlp.url'). '/embeddings', [
                'text' => $title
            ]);

            $embeddings = $response->json();

            BookEmbedding::updateOrCreate([
                'book_id' => $book->id,
            ], [
                'embeddings_model' => $embeddings['model'],
                'embeddings' => $embeddings['embeddings'],
            ]);
        }
    }

    /**
     * Calculate sentiment for books
     * @param array|Collection<BookDto> $books
     * @return void
     */
    public function calculateSentiment($books)
    {
        for ($i = 0; $i < count($books); $i++) {

            $book = $books[$i];
            $title = $book->title;

            $response = Http::post(config('services.nlp.url'). '/nlp', [
                'text' => $title
            ]);

            $nlp = $response->json();

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

            BookSentiment::updateOrCreate([
                'book_id' => $book->id,
            ], [
                'sentiment_model' => $nlp['model'],
                'positive_sentiment' => $positive,
                'negative_sentiment' => $negative,
                'neutral_sentiment' => $neutral,
            ]);
        }

    }

}
