<?php

namespace App\Http\Controllers\Book;

use App\Facades\Notify;
use App\Http\Controllers\Controller;
use App\Models\Books\Author;
use App\Models\Books\Book;
use App\Models\Books\Category;
use Illuminate\Http\Request;

class BookUpdateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, int $id)
    {
        $book = Book::findOrFail($id);

        $book->update([
            'title' => $request->title,
            'description' => $request->description,
            'year' => $request->year,
            'catalog' => $request->catalog,
            'editorial' => $request->editorial,
            'city' => $request->city,
            'reference' => $request->reference,
        ]);

        $category = Category::findOrFail($request->category['id']);

        $book->category()->associate($category);

        $authors = collect($request->authors)->map(function ($author) {
            Author::findOrFail($author['id'])->update([
                'name' => $author['name'],
            ]);
        });

        $book->save();

        Notify::success(trans('book.book_updated'));

        return back();
    }
}
