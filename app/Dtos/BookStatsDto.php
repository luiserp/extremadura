<?php

namespace App\Dtos;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript()]
class BookStatsDto extends Data
{
    public function __construct(
        public string $name,
        public array $labels,
        public array $data,
    ) {}
}
