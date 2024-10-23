<?php

namespace App\Dtos;

use App\Models\Books\Book;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript()]
class BookDto extends Data
{
    public int $id;
    public string $title;
    public string $description;
    public string $year;
    public string $catalog;
    public ?string $editorial;
    public ?string $city;
    public ?string $reference;
    public ?bool $has_embeddings;
    public ?bool $has_sentiment;
    public ?bool $has_description;
    public ?bool $active;
    public ?bool $ready;
    public ?CategoryDto $category;
    #[DataCollectionOf(AuthorDto::class)]
    public array $authors = [];
    public ?BookEmbeddingDto $embedding;
    public ?BookSentimentDto $sentiment;
    public ?BookDescriptionDto $bookDescription;
    public $media = null;
    public $image_urls = null;
    public ?BookDto $nextBook;
    public ?BookDto $previousBook;

    // Control the data that is returned
    public $withBoundaries = false;

    public static function withBoundaries(mixed $data): static
    {
        $book = self::from($data);
        $book->withBoundaries = true;

        $nextBook = Book::where('id', '>', $book->id)
            ->orderBy('id', 'asc')
            ->first();

        $previousBook = Book::where('id', '<', $book->id)
            ->orderBy('id', 'desc')
            ->first();

        $book->nextBook = $nextBook ? self::from($nextBook) : null;
        $book->previousBook = $previousBook ? self::from($previousBook) : null;

        return $book;
    }

    public function with(): array
    {
        $imageUrls = $this->media?->map(function ($media) {
            return [
                'id' => $media->id,
                'url' => $media->getUrl()
            ];
        });

        return [
            'image_urls' => $imageUrls
        ];
    }

}
