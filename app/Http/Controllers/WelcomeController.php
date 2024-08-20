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

    public function __construct(
        protected BookStatsService $bookStatsService
    )
    {
        //
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {

        $books = Book::where('active', 1)->take(6)->get();

        $bookCitiesStats = $this->bookStatsService->getStats('book_cities');

        $bookAuthorsStats = $this->bookStatsService->getStats('book_authors');

        $bookCategoriesStats = $this->bookStatsService->getStats('book_categories');

        $citiesCategoriesStats = $this->bookStatsService->getStats('book_cities_categories');

        return Inertia::render('Welcome', [
            'books' => BookDto::collect($books),
            'bookCitiesStats' => BookStatsDto::from($bookCitiesStats),
            'bookAuthorsStats' => BookStatsDto::from($bookAuthorsStats),
            'bookCategoriesStats' => BookStatsDto::from($bookCategoriesStats),
            'citiesCategoriesStats' => BookStatsDto::from($citiesCategoriesStats),
        ]);
    }
}
