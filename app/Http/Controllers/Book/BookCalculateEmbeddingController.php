<?php

namespace App\Http\Controllers\Book;

use App\Facades\Notify;
use App\Http\Controllers\Controller;
use App\Jobs\BookCalculateEmbeddingJob;
use App\Models\Books\Book;
use Illuminate\Http\Request;

class BookCalculateEmbeddingController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $to = $request->to;

        if ($to) {
            $books = collect([Book::findOrFail($to)]);
        } else {
            $books = Book::all();
        }

        BookCalculateEmbeddingJob::dispatch($books, auth()->user());

        Notify::success(trans('book.book_calculating_embeddings'));

        return redirect()->back();
    }
}
