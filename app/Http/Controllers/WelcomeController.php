<?php

namespace App\Http\Controllers;

use App\Dtos\BookDto;
use App\Dtos\BookStatsDto;
use App\Models\Books\Book;
use App\Services\Stats\BookStatsService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WelcomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {

        $books = Book::with(['category', 'authors', 'embedding', 'sentiment', 'bookDescription', 'media'])
            ->where('active', 1)->inRandomOrder()->take(12)->get();

        return Inertia::render('Welcome/Welcome', [
            'books' => BookDto::collect($books),
        ]);
    }
}
