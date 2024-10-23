<?php

namespace App\Http\Controllers\Book\Api;

use App\Dtos\BookBoundsDto;
use App\Dtos\BookDto;
use App\Dtos\BookFilterDto;
use App\Http\Controllers\Controller;
use App\Models\Books\Book;
use Illuminate\Http\Request;

class BookGetBounds extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, string $id)
    {

        $filters = BookFilterDto::from($request->all());

        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'message' => 'Book not found',
            ], 404);
        }

        $nextBook = Book::where('id', '>', $id)
            ->orderBy('id', 'asc')
            ->first();

        $previousBook = Book::where('id', '<', $id)
            ->orderBy('id', 'desc')
            ->first();


        return response()->json(BookBoundsDto::from([
            'book' => $book,
            'nextBook' => $nextBook,
            'previousBook' => $previousBook,
        ]));
    }
}
