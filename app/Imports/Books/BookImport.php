<?php

namespace App\Imports\Books;

use App\Models\Books\Author;
use App\Models\Books\Book;
use App\Models\Books\Category;
use App\Models\Books\Editorial;
use App\Models\Books\City;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;

class BookImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {

            if ($row['author'] === '' || $row['editorial'] === '' || $row['category'] === '' || $row['title'] === ''
                || $row['author'] === null || $row['editorial'] === null || $row['category'] === null || $row['title'] === null
            ) {
                continue;
            }

            $authorsRows = explode(';', $row['author']);
            $authors = [];

            foreach ($authorsRows as $author) {
                $authors[] = Author::firstOrCreate([
                    'name' => $author,
                ]);
            }

            $editorial = Editorial::firstOrCreate([
                'name' => $row['editorial'],
            ]);

            $category = Category::firstOrCreate([
                'name' => Str::upper($row['category']),
            ]);


            if ($row['city'] === '' || $row['city'] === null) {
                $row['city'] = 'Desconocida';
            }

            $city = City::firstOrCreate([
                'name' => $row['city'],
            ]);

            $book = Book::firstOrCreate(
                [
                    'title' => $row['title'],
                    'year' => $row['year'],
                ],
                [
                    'description' => $row['description'],
                    'catalog' => $row['catalog'],
                    'editorial_id' => $editorial->id,
                    'category_id' => $category->id,
                    'city_id' => $city->id,
                ]
            );

            $book->authors()->sync(collect($authors)->pluck('id'));

        }
    }
}
