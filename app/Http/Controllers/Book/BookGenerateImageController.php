<?php

namespace App\Http\Controllers\Book;

use App\Facades\Notify;
use App\Http\Controllers\Controller;
use App\Jobs\BookGenerateImageJob;
use App\Models\Books\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;

class BookGenerateImageController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $to = $request->to;

        if ($to) {
            $books = collect(Book::findOrFail($to));
        } else {
            $books = Book::all();
        }

        $jobs = [];
        foreach ($books as $book) {
            $jobs[] = new BookGenerateImageJob(collect([$book]), $request->user());
        }

        Bus::chain($jobs)->dispatch();

        Notify::success(trans('book.book_generate_image_in_progress'));

        return redirect()->back();
    }
}
