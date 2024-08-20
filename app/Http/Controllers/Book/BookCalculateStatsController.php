<?php

namespace App\Http\Controllers\Book;

use App\Facades\Notify;
use App\Http\Controllers\Controller;
use App\Jobs\CreateBookStatsJob;
use Illuminate\Http\Request;

class BookCalculateStatsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        CreateBookStatsJob::dispatch($request->user());

        Notify::success(trans('book.calculate_stats_in_progress'));
    }
}
