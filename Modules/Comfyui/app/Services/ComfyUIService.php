<?php


namespace Modules\Comfyui\Services;

use Ramsey\Uuid\Uuid;

class ComfyUIService
{

    protected PromptService $promptService;
    protected ImageService $imageService;
    protected WebSocketService $webSocketService;
    protected HistoryService $historyService;

    protected string $clientId;

    public function __construct()
    {
        $this->clientId = Uuid::uuid4()->toString();

        $this->promptService = new PromptService($this->clientId);
        $this->imageService = new ImageService();
        $this->webSocketService = new WebSocketService($this->clientId);
        $this->historyService = new HistoryService();
    }

    public function generateImage($text, $seed = 0): array
    {
        $promptResponse = $this->promptService->queuePrompt($text, $seed);
        $done = $this->webSocketService->getImages($promptResponse);
        $history = $this->historyService->getHistory($promptResponse['prompt_id']);
        $paths = $this->imageService->getImageFromHistory( $history, $promptResponse['prompt_id']);

        return $paths;
    }
}
