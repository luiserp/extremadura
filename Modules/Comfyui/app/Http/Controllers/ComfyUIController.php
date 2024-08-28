<?php

namespace Modules\Comfyui\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Comfyui\app\Services\ComfyUIService;

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
            $urls[] = asset($path);
        }

        // Save the images or perform further actions
        return response()->json([
            'message' => $urls,
        ]);
    }
}
