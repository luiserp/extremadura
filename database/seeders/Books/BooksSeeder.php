<?php

namespace Database\Seeders\Books;

use App\Imports\Books\BookImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class BooksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // File 1
        $file = 'books/books.csv';
        Excel::import(new BookImport, $file);

        // File 2
        $file = 'books/2022-23.csv';
        Excel::import(new BookImport, $file);
    }
}
