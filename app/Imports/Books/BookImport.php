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

            // if ($row['author'] === '' || $row['editorial'] === '' || $row['category'] === '' || $row['title'] === ''
            //     || $row['author'] === null || $row['editorial'] === null || $row['category'] === null || $row['title'] === null
            // ) {
            //     continue;
            // }

            $authorsRows = explode(';', $row['author']);
            $authors = [];

            foreach ($authorsRows as $author) {
                $authors[] = Author::firstOrCreate([
                    'name' => $author,
                ]);
            }

            if (array_key_exists('category', $row->toArray())) {
                $category = Category::firstOrCreate([
                    'name' => Str::upper(strtolower($row['category'])),
                ]);
            } else {
                $category = Category::firstOrCreate([
                    'name' => 'Desconocida',
                ]);
            }

            if ($row['city'] === '' || $row['city'] === null) {
                $row['city'] = 'Desconocida';
            }

            $book = Book::firstOrCreate(
                [
                    'title' => $row['title'],
                    'year' => $row['year'],
                ],
                [
                    'description' => array_key_exists('description', $row->toArray()) ? $row['description'] : null,
                    'catalog' => $row['catalog'],
                    'category_id' => $category->id,
                    'editorial' => $row['editorial'],
                    'city' => $row['city'],
                    'reference' => $row['reference'],
                ]
            );

            $book->authors()->sync(collect($authors)->pluck('id'));

        }
    }
}
