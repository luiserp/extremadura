<?php

namespace App\Exports;

use App\Models\Books\Book;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BookExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Book::all();
    }

    public function headings(): array
    {
        return [
            'Title',
            'Authors',
            'Description',
            'Editorial',
            'Category',
            'Year',
            'City',
            'Catalog',
            'Reference',
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
