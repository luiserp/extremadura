<?php

namespace App\Http\Controllers\Book;

use App\Exports\BookExport;
use App\Facades\Notify;
use App\Http\Controllers\Controller;
use App\Jobs\BookExportJob;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BookExportController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {

        dispatch(new BookExportJob($request->user()));

        Notify::success(trans('book.export_books_in_progress'));

    }
}
