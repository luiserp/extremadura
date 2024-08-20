<?php


namespace App\Services\Stats;

use App\Models\Books\Author;
use App\Models\Books\Book;
use App\Models\Stats;

class BookStatsService
{
    public function getStats(string $name): Stats|null
    {
        $stats = Stats::where('name', $name)->first();

        return $stats;
    }

    public function updateStats(string $name, array $labels, array $data): void
    {
        Stats::updateOrCreate(
            ['name' => $name],
            ['labels' => $labels, 'data' => $data]
        );
    }

    public function deleteStats(string $name): void
    {
        Stats::where('name', $name)->delete();
    }

    public function calculateCitiesStats()
    {
        $cities = Book::select('city', Book::raw('count(*) as total'))
            ->groupBy('city')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        $labels = $cities->pluck('city')->toArray();
        $data = $cities->pluck('total')->toArray();

        $this->updateStats('book_cities', $labels, $data);
    }

    public function calculateAuthorsStats()
    {
        $authors = Author::select('name as author', Book::raw('count(*) as total'))
            ->join('author_book', 'authors.id', '=', 'author_book.author_id')
            ->groupBy('author')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        $labels = $authors->pluck('author')->toArray();
        $data = $authors->pluck('total')->toArray();

        $this->updateStats('book_authors', $labels, $data);
    }

    public function calculateCategoryStats()
    {
        $categories = Book::select('categories.name as category', Book::raw('count(*) as total'))
            ->join('categories', 'books.category_id', '=', 'categories.id')
            ->groupBy('category')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        $labels = $categories->pluck('category')->toArray();
        $data = $categories->pluck('total')->toArray();

        $this->updateStats('book_categories', $labels, $data);

    }

    public function calculateBooksByCityAndCategory()
    {

        // [
        //     [
        //         'category' => 'category1',
        //         'total' => [10, 20, 30, 40, 50]
        //     ],
        // ]

        $cities = Book::select('city', Book::raw('count(*) as total'))
            ->groupBy('city')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();


        $stats = [];
        foreach ($cities as $city) {

            $categories = Book::select('categories.name as category', Book::raw('count(*) as total'))
                ->join('categories', 'books.category_id', '=', 'categories.id')
                ->where('city', $city->city)
                ->groupBy('category')
                ->orderBy('total', 'desc')
                ->get();

            $subStats = [];
            foreach ($categories as $category) {
                $subStats[] = [
                    'category' => $category->category,
                    'total' => $category->total
                ];
            }

            $stats[$city->city] = $subStats;
        }

        // Transform the data to the format that the stats table expects
        $newStats = [];
        foreach ($stats as $city => $categories) {
            foreach ($categories as $category) {
                $key = array_search($category['category'], array_column($newStats, 'name'));

                if ($key === false) {
                    $newStats[] = [
                        'name' => $category['category'],
                        'data' => [$category['total']]
                    ];
                } else {
                    $newStats[$key]['data'][] = $category['total'];
                }
            }
        }


        $this->updateStats('book_cities_categories', $cities->pluck('city')->toArray(), $newStats);
    }
}
