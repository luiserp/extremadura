<?php

namespace App\Http\Controllers\Book;

use App\Facades\Notify;
use App\Http\Controllers\Controller;
use App\Jobs\BookImportJob;
use Illuminate\Http\Request;

class ImportBookController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {

        $user = $request->user();
        $file = $request->file('file');
        $name = $file->getBasename() . '-' . time() . '.' . $file->getClientOriginalExtension();
        $path = "books/{$user->id}/";

        // save the file
        $file->storeAs($path, $name);

        BookImportJob::dispatch($request->user(), $path . $name);

        Notify::success(trans('book.import_books_in_progress'));
    }
}
