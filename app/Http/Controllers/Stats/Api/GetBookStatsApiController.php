<?php

namespace App\Http\Controllers\Stats\Api;

use App\Dtos\BookStatsDto;
use App\Http\Controllers\Controller;
use App\Services\Stats\BookStatsService;
use Illuminate\Http\Request;

class GetBookStatsApiController extends Controller
{

    public function __construct(
        private BookStatsService $bookStatsService
    )
    {
        //
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $bookCitiesStats = $this->bookStatsService->getStats('book_cities');

        $bookAuthorsStats = $this->bookStatsService->getStats('book_authors');

        $bookCategoriesStats = $this->bookStatsService->getStats('book_categories');

        $citiesCategoriesStats = $this->bookStatsService->getStats('book_cities_categories');

        return response()->json([
            'bookCitiesStats' => $bookCitiesStats ? BookStatsDto::from($bookCitiesStats) : null,
            'bookAuthorsStats' => $bookAuthorsStats ? BookStatsDto::from($bookAuthorsStats) : null,
            'bookCategoriesStats' => $bookCategoriesStats ? BookStatsDto::from($bookCategoriesStats) : null,
            'citiesCategoriesStats' => $citiesCategoriesStats ? BookStatsDto::from($citiesCategoriesStats) : null,
        ]);
    }
}
