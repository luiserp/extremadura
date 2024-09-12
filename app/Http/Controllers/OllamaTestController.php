<?php

namespace App\Http\Controllers;

use Cloudstudio\Ollama\Facades\Ollama;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OllamaTestController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {

        $response = Ollama::agent('You are a weather expert...')
            ->prompt('Why is the sky blue?')
            ->model('llama2')
            ->options(['temperature' => 0.8])
            ->stream(false)
            ->ask();

        return response()->json($response);

    }
}
