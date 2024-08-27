<?php

namespace App\Http\Controllers\Book;

use App\Dtos\BookDto;
use App\Dtos\BookFilterDto;
use App\Dtos\CategoryDto;
use App\Dtos\EditorialDto;
use App\Http\Controllers\Controller;
use App\Models\Books\Book;
use App\Models\Books\BookDescription;
use App\Models\Books\BookEmbedding;
use App\Models\Books\BookSentiment;
use App\Models\Books\Category;
use App\Models\Books\City;
use App\Models\Books\Editorial;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookIndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // Get data from request
        $filters = BookFilterDto::from($request->toArray());
        $page = $request->input('page', 1);
        $perPage = $request->input('per_page', 15);

        // Get books
        $books = Book::
            with(['category', 'authors'])
            // Search
            ->when($filters->search, function ($query, $search) {
                $query->where('title', 'like', "%$search%")
                    ->orWhere('city', 'like', "%$search%")
                    ->orWhere('editorial', 'like', "%$search%")
                    ->orWhereHas('authors', function ($query) use ($search) {
                        $query->where('name', 'like', "%$search%");
                    });

            })->addSelect([
                'has_embeddings' => BookEmbedding::selectRaw('count(*)')
                    ->whereColumn('book_id', 'books.id'),
                'has_sentiment' => BookSentiment::selectRaw('count(*)')
                    ->whereColumn('book_id', 'books.id'),
                'has_description' => BookDescription::class::selectRaw('count(*)')
                    ->whereColumn('book_id', 'books.id'),
            ])
            // Dates
            ->when($filters->dates, function ($query, $dates) {
                $start = Carbon::parse($dates[0])->year;
                $end = Carbon::parse($dates[1])->year;
                $query->whereBetween('year', [$start, $end]);
            })
            ->when($filters->year, function ($query, $year) {
                $query->where('year', $year);
            })
            // Categories
            ->when($filters->categories, function ($query, $categories) {
                $query->whereIn('category_id', $categories);
            })
            // Status
            ->when($filters->status, function ($query, $status) {
                $query->where('active', $status[0]);
            })
            ->paginate(
                perPage: $perPage,
                page: $page
            );

        // Get unique Categories
        $categories = Category::all();

        return Inertia::render('Book/Index', [
            'books' => BookDto::collect($books),
            'filters' => $filters,
            'categories' => CategoryDto::collect($categories),
        ]);
    }
}
