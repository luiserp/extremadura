<?php

namespace App\Dtos;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript()]
class BookSentimentDto extends Data
{
    public int $id;
    public string $book_id;
    public string $sentiment_model;
    public string $positive_sentiment;
    public string $negative_sentiment;
    public string $neutral_sentiment;
    public string $created_at;
    public string $updated_at;
}
