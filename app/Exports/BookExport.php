<?php

namespace App\Exports;

use App\Models\Books\Book;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BookExport implements FromCollection, WithHeadings, WithMapping
{

    public function __construct(protected string $catalog)
    {
        //
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Book::where('catalog', $this->catalog)->get();
    }

    public function headings(): array
    {
        return [
            'title',
            'author',
            'description',
            'editorial',
            'category',
            'year',
            'city',
            'catalog',
            'reference',
        ];
    }

    /**
     * Map the data
     *
     * @param Book $book
     * @return array
     */
    public function map($book): array
    {
        $authors = $book->authors->map(function ($author) {
            return $author->name;
        })->implode(';');

        return [
            $book->title,
            $authors,
            $book->description,
            $book->editorial,
            $book->category->name,
            $book->year,
            $book->city,
            $book->catalog,
            $book->reference,
        ];
    }
}
