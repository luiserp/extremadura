<?php

namespace App\Http\Controllers\Book;

use App\Facades\Notify;
use App\Http\Controllers\Controller;
use App\Jobs\BookCalculateSentimentJob;
use App\Models\Books\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class BookCalculateSentimentController extends Controller
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

        BookCalculateSentimentJob::dispatch($books, auth()->user());

        Notify::success(trans('book.book_calculating_sentiment'));

        return redirect()->back();
    }
}
