<?php

namespace App\Http\Controllers;

use App\Dtos\BookDto;
use App\Models\Books\Book;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WelcomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {

        $books = Book::where('active', 1)->take(6)->get();

        return Inertia::render('Welcome', [
            'books' => BookDto::collect($books),
        ]);
    }
}
