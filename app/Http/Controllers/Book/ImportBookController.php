<?php

namespace App\Http\Controllers\Book;

use App\Facades\Notify;
use App\Http\Controllers\Controller;
use App\Jobs\BookImportJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;

class ImportBookController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = $request->user();
        $files = $request->file('files');
        $batch = [];

        foreach ($files as $file) {
            $name = $file->getBasename() . '-' . time() . '.' . $file->getClientOriginalExtension();
            $path = "books/{$user->id}/";

            // save the file
            $file->storeAs($path, $name);

            $batch[] = new BookImportJob($request->user(), $path . $name);
        }

        Bus::chain($batch)->dispatch();

        Notify::success(trans('book.import_books_in_progress'));
    }
}
