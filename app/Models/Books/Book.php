<?php

namespace App\Models\Books;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    use HasFactory;


    protected $guarded = [];

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class);
    }

}
