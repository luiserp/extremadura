<?php

namespace App\Http\Controllers\Book;

use App\Facades\Notify;
use App\Http\Controllers\Controller;
use App\Models\Books\Book;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

class BookDeleteController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, string $id)
    {
        $previousUrl = url()->previous();
        $previousUrlName = Route::getRoutes()->match(app('request')->create($previousUrl))->getName();

        $book = Book::findOrFail($id);

        $book->delete();

        Notify::success('Book deleted successfully');

        if ($previousUrlName === 'books.detail') {
            return redirect()->route('books.index');
        }

        return redirect()->back();
    }
}
