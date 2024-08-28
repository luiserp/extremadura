<?php

namespace Modules\Comfyui\app\Services;

use GuzzleHttp\Client;

class HistoryService
{
    protected $serverAddress;
    protected $client;

    public function __construct()
    {
        $this->serverAddress = config('comfyui.COMFYUI_URL');
        $this->client = new Client();
    }

    public function getHistory($promptId)
    {
        $response = $this->client->get("http://{$this->serverAddress}/history/{$promptId}");

        return json_decode($response->getBody(), true);
    }
}
