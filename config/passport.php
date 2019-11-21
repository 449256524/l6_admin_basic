<?php


return [
    'admin_api' => [
        'grant_type' => env('OAUTH_GRANT_TYPE'),
        'client_id' => env('OAUTH_CLIENT_ID'),
        'client_secret' => env('OAUTH_CLIENT_SECRET'),
        'scope' => env('OAUTH_SCOPE', '*'),
        'guard' => 'admin_api',
    ]
];
