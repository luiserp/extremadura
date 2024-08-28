<?php

namespace Modules\Comfyui\app\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    protected $serverAddress;
    protected $client;

    public function __construct()
    {
        $this->serverAddress = config('comfyui.COMFYUI_URL');
        $this->client = new Client();
    }

    /**
     * Get image from history
     *
     * @param array $history
     * @param string $promptId
     * @return array $paths
     */
    public function getImageFromHistory(array $history, string $promptId): array
    {
        $promtHistory = $history[$promptId];
        $outputs = $promtHistory['outputs'];
        $paths = [];

        foreach ($outputs as $output) {
            foreach ($output as $images) {
                foreach ($images as $image) {

                    $comfyImage = $this->getImage($image['filename'], $image['subfolder'], $image['type']);
                    $paths[] = $this->storeImage($comfyImage, $image['filename'], $promptId);
                }
            }
        }

        return $paths;
    }


    /**
     * Store image on server
     *
     * @param string $image
     * @param string $filename
     * @param string $promptId
     * @return string $path
     */
    public function storeImage(string $image, string $filename, string $promptId): string
    {
        $storagePath = config('comfyui.output.image.path');

        $path = $storagePath . "/{$promptId}/{$filename}";

        Storage::disk('comfyui_media')->put($path, $image);

        return $path;
    }

    /**
     * Get image from server
     *
     * @param string $filename
     * @param string $subfolder
     * @param string $folderType
     * @return string $image
     */
    public function getImage(string $filename, string $subfolder, string $folderType): string
    {
        $data = [
            'filename' => $filename,
            'subfolder' => $subfolder,
            'type' => $folderType,
        ];

        $response = $this->client->get("http://{$this->serverAddress}/view", [
            'query' => $data,
        ]);

        return $response->getBody()->getContents();
    }
}
