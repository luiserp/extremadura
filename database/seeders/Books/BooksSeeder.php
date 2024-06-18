<?php

namespace Database\Seeders\Books;

use App\Imports\Books\BookImport;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class BooksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $file = 'books/books.csv';

        Excel::import(new BookImport, $file);

    }
}
