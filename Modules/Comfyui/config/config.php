<?php

return [
    'name' => 'Comfyui',

    'COMFYUI_URL' => env('COMFYUI_URL', 'host.docker.internal:8188'),


    'output' => [
        'image' => [
            'path' => '/comf/images',
        ],
    ],

];
