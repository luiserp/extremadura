<?php

namespace App\Imports\Books;

use App\Models\Books\Author;
use App\Models\Books\Book;
use App\Models\Books\Category;
use App\Models\Books\Editorial;
use App\Models\Books\City;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class BookImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row) {

            try {
                $authorsRows = explode(';', $row['author']);
                $authors = [];

                foreach ($authorsRows as $author) {
                    $authors[] = Author::firstOrCreate([
                        'name' => $this->encodeUtf8($author),
                    ]);
                }

                if (array_key_exists('category', $row->toArray())) {
                    $category = Category::firstOrCreate([
                        'name' => Str::trim(Str::upper(strtolower($this->encodeUtf8($row['category'])))),
                    ]);
                } else {
                    $category = Category::firstOrCreate([
                        'name' => 'Desconocida',
                    ]);
                }

                if ($row['city'] === '' || $row['city'] === null) {
                    $row['city'] = 'Desconocida';
                }

                $year = is_numeric($row['year']) ? $row['year'] : null;

                $book = Book::firstOrCreate(
                    [
                        'title' => $this->encodeUtf8($row['title']),
                        'year' => $year,
                    ],
                    [
                        'description' => array_key_exists('description', $row->toArray()) ? $row['description'] : null,
                        'catalog' => $this->encodeUtf8($row['catalog']),
                        'category_id' => $category->id,
                        'editorial' => $this->encodeUtf8($row['editorial']),
                        'city' => $this->encodeUtf8($row['city']),
                        'reference' => $this->encodeUtf8($row['reference']),
                        'active' => true,
                    ]
                );

                $book->authors()->sync(collect($authors)->pluck('id'));

            } catch (\Exception $e) {
                Log::error('Error importing book: ', [
                    'message' => $e->getMessage(),
                    'row' => $row,
                ]);
            }
        }
    }

    public function encodeUtf8($value)
    {
        return mb_convert_encoding($value, 'UTF-8', 'auto');
    }
}
