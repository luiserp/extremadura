<?php

namespace App\Http\Controllers\Book;

use App\Facades\Notify;
use App\Http\Controllers\Controller;
use App\Jobs\BookDeleteAllJob;
use Illuminate\Http\Request;

class DeleteAllBooksController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // Delete all books
        BookDeleteAllJob::dispatch($request->user());

        Notify::success(trans('book.delete_all_books_in_progress'));
    }
}
