<?php

namespace App\Dtos;

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
    public CategoryDto $category;
    public EditorialDto $editorial;
    #[DataCollectionOf(AuthorDto::class)]
    public array $authors;
    public CityDto $city;
}