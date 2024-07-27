<?php

namespace App\Http\Controllers\Book;

use App\Facades\Notify;
use App\Http\Controllers\Controller;
use App\Jobs\BookAskAssistantJob;
use App\Models\Books\Book;
use Illuminate\Http\Request;

class BookAskAssistantController extends Controller
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

        BookAskAssistantJob::dispatch($books, $request->user());

        Notify::success('Book ask assistant job dispatched');

        return back();
    }
}
