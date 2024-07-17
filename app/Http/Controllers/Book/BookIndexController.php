<?php

namespace App\Http\Controllers\Book;

use App\Dtos\BookDto;
use App\Http\Controllers\Controller;
use App\Models\Books\Book;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookIndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {

        $page = $request->input('page', 1);
        $perPage = $request->input('per_page', 10);

        $books = Book::
            with(['category', 'editorial', 'authors', 'city'])
            ->paginate(
                perPage: $perPage,
                page: $page
            );

        return Inertia::render('Book/Index', [
            'books' => BookDto::collect($books),
        ]);
    }
}
