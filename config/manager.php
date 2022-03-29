<?php

return [
    'twitch' => [
        'default_driver' => env('MANAGER_TWITCH_DEFAULT_DRIVER'),
        'drivers' => [
            'rawapi' => [
                'client_id' => env('TWITCH_RAWAPI_CLIENT_ID'),
                'client_secret' => env('TWITCH_RAWAPI_CLIENT_SECRET'),
                'broadcaster_id' => '50119422',
                'endpoints' => [
                    'oauth2' => 'https://id.twitch.tv/oauth2/token',
                    'user' => 'https://api.twitch.tv/helix/users',
                    'clips' => 'https://api.twitch.tv/helix/clips',
                    'games' => 'https://api.twitch.tv/helix/games',
                ],
            ]
        ],
    ],
];
