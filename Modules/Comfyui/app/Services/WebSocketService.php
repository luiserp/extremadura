<?php

namespace Modules\Comfyui\app\Services;

use Illuminate\Support\Facades\Log;
use WebSocket\Client;

class WebSocketService
{
    protected $serverAddress;

    public function __construct(
        protected string $clientId
    ) {
        $this->serverAddress = config('comfyui.COMFYUI_URL');
    }

    public function getImages($prompt)
    {
        $ws = new Client("ws://{$this->serverAddress}/ws?clientId={$this->clientId}", [
            'timeout' => -1,
        ]);

        while (true) {

            Log::info('WebSocket message: ', [
                'message' => 'Waiting for message',
            ]);

            $out = $ws->receive();

            Log::info('WebSocket message: ', [
                'message' => $out,
            ]);

            if (is_string($out)) {

                $message = json_decode($out, true);

                if ($message['type'] === 'executing') {
                    $data = $message['data'];
                    if (array_key_exists('prompt_id', $data) && $data['prompt_id'] == $prompt['prompt_id']) {
                        if ($data['node'] === null) {
                            break; // Execution is done
                        }
                    }
                }

                if ($message['type'] === 'status') {
                    $data = $message['data']['status'];
                    $execInfo = $data['exec_info'];
                    if ($execInfo['queue_remaining'] === 0) {
                        break; // Execution is done
                    }
                }

            } else {
                Log::info('WebSocket message: ', [
                    'message' => 'Unknown message type',
                ]);
                continue; # previews are binary data
            }

        }

        $ws->close();

        return true;
    }
}
