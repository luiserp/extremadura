<?php

namespace App\Dtos;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

#[TypeScript()]
class EditorialDto extends Data
{
    public int $id;
    public string $name;
    public string $created_at;
    public string $updated_at;
}
