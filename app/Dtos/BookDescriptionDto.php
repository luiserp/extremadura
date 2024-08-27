<?php

namespace App\Dtos;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript()]
class BookDescriptionDto extends Data
{
    public int $id;
    public string $book_id;
    public string $description;
    public string $model;
    public string $created_at;
    public string $updated_at;
}
