<?php

namespace App\Dtos;

use App\Models\Books\Book;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript()]
class BookBoundsDto extends Data
{
    public ?BookDto $book;
    public ?BookDto $nextBook;
    public ?BookDto $previousBook;
}
