<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Broadcaster
    |--------------------------------------------------------------------------
    */

    'default' => env('BROADCAST_DRIVER', 'reverb'),

    /*
    |--------------------------------------------------------------------------
    | Broadcast Connections
    |--------------------------------------------------------------------------
    */

    'connections' => [

        // Reverb connection
   'reverb' => [
        'driver' => 'reverb',
        'key' => env('REVERB_APP_KEY'),
        'secret' => env('REVERB_APP_SECRET'),
        'app_id' => env('REVERB_APP_ID'),
        'options' => [
            'host' => env('REVERB_HOST'),
            'port' => env('REVERB_PORT', 8080),
            'scheme' => env('REVERB_SCHEME', 'http'),
            'useTLS' => env('REVERB_SCHEME', 'https') === 'https',
        ],
    ],

        // Dummy Pusher (so Laravel doesn't break)
        'pusher' => [
            'driver' => 'pusher',
            'key' => env('PUSHER_APP_KEY', 'local'),
            'secret' => env('PUSHER_APP_SECRET', 'local'),
            'app_id' => env('PUSHER_APP_ID', 'local'),
            'options' => [
                'cluster' => env('PUSHER_APP_CLUSTER', 'mt1'),
                'host' => env('PUSHER_HOST', '127.0.0.1'),
                'port' => env('PUSHER_PORT', 6001),
                'scheme' => env('PUSHER_SCHEME', 'http'),
                'useTLS' => false,
                'encrypted' => false,
            ],
        ],

        'ably' => [
            'driver' => 'ably',
            'key' => env('ABLY_KEY'),
        ],

        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
        ],

        'log' => [
            'driver' => 'log',
        ],

        'null' => [
            'driver' => 'null',
        ],

    ],

];
