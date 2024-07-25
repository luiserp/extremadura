<?php

namespace App\Http\Controllers\Book\Api;

use App\Dtos\BookDto;
use App\Http\Controllers\Controller;
use App\Models\Books\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BookGetActiveBook extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {

        Log::info('Get active book');

        $books = Book::with(['category', 'editorial', 'authors', 'city', 'embedding', 'sentiment'])
            ->where('active', true)
            ->get();

        if ($books->isEmpty()) {
            return response()->json([
                'message' => 'No active book found',
            ], 404);
        }

        $book = $books->random();

        return response()->json(BookDto::from($book));
    }
}
