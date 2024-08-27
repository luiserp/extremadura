<?php

namespace App\Http\Controllers\BookDescription;

use App\Facades\Notify;
use App\Http\Controllers\Controller;
use App\Jobs\BookCreatePromptJob;
use App\Models\Books\Book;
use Illuminate\Http\Request;

class BookCreateDescriptionController extends Controller
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

        BookCreatePromptJob::dispatch($books, auth()->user());

        Notify::success(trans('book.book_create_prompt_in_progress'));

        return redirect()->back();
    }
}
