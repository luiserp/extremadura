<?php

namespace App\Http\Controllers\Book;

use App\Dtos\BookDto;
use App\Http\Controllers\Controller;
use App\Models\Books\Book;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookDetailController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, string $id)
    {

        $book = Book::with(['category', 'editorial', 'authors', 'city'])
            ->where('id', $id)
            ->firstOrFail();

        return Inertia::render('Book/Detail', [
            'book' => BookDto::from($book),
        ]);


    }
}
