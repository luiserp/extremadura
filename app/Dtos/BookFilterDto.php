<?php

namespace App\Dtos;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript()]
class BookFilterDto extends Data
{
    public ?string $search = null;
    public ?array $dates = null;
    public ?string $year = null;
    public ?array $categories = null;
    public ?array $status = null;
}
