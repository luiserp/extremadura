<?php

namespace App\Http\Controllers\Book;

use App\Dtos\BookDto;
use App\Http\Controllers\Controller;
use App\Models\Books\Book;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookSetActiveController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, string $id)
    {
        $book = Book::findOrFail($id);

        $book->active = !$book->active;

        $book->save();

        return back();
    }
}
