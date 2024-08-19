<?php

namespace App\Http\Controllers\Devtools;

use App\Facades\Notify;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TestBroadcastingController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {

        $user = $request->user();

        Notify::realtime()->to($user)->success('Hello Realtime!');

        dispatch(function () use ($user) {
            Notify::realtime()->to($user)->success('Hello Realtime from queue! (5 seconds delay)');
            Log::info('Realtime message sent from queue! (5 seconds delay)');

        })->delay(now()->addSeconds(5));


        Notify::success('Realtime message sent!');

    }
}
