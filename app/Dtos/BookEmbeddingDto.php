<?php

namespace App\Dtos;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript()]
class BookEmbeddingDto extends Data
{
    public int $id;
    public string $book_id;
    public string $embeddings_model;
    public array $embeddings;
    public string $created_at;
    public string $updated_at;
}
