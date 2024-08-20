<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stats extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'labels', 'data'];

    protected $casts = [
        'labels' => 'array',
        'data' => 'array',
    ];
}
