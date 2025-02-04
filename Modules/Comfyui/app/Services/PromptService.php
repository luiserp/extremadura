<?php

namespace Modules\Comfyui\Services;

use GuzzleHttp\Client;

class PromptService
{
    protected $serverAddress;
    protected $client;

    public function __construct(
        protected string $clientId
    )
    {
        $this->serverAddress = config('comfyui.COMFYUI_URL');
        $this->client = new Client();
    }

    public function getPrompt()
    {
        $json = file_get_contents(storage_path('app/comfyui/comfyui workflow.json'));
        $workflow = json_decode($json, true);
        return $workflow;
    }

    public function queuePrompt($text, $seed = 0)
    {
        $prompt = $this->getPrompt();

        $prompt["6"]["inputs"]["text"] = $text;
        $prompt["10"]["inputs"]["noise_seed"] = $seed;

        $data = [
            'prompt' => $prompt,
            'client_id' => $this->clientId,
        ];

        $response = $this->client->post("http://{$this->serverAddress}/prompt", [
            'json' => $data,
        ]);

        return json_decode($response->getBody(), true);
    }
}
