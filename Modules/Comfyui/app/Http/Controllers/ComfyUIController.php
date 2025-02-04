<?php

namespace Modules\Comfyui\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Modules\Comfyui\Services\ComfyUIService;

class ComfyUIController extends Controller
{

    protected ComfyUIService $comfyUIService;

    public function __construct()
    {
        $this->comfyUIService = new ComfyUIService();
    }

    public function __invoke(Request $request)
    {
        $prompt = $request->get('prompt', 'A beautiful sunset over the mountains.');

        $paths = $this->comfyUIService->generateImage($prompt);

        // Move the images to the public folder
        foreach ($paths as $path) {
            $route = asset("storage/comf/images{$path}");
            $urls[] = $route;
        }

        Artisan::call('storage:link');

        // Save the images or perform further actions
        return response()->json([
            'message' => $urls,
        ]);
    }
}
