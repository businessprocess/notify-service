<?php

return [
    'messenger' => [
        'authentication' => env('MESSENGER_AUTHORIZATION'),
        'url' => env('MESSENGER_HOST'),
        'project_id' => env('MESSENGER_PROJECT_ID'),
        'messenger' => explode(',', env('MESSENGER_LIST', 'viber')),
        'sendAll' => env('MESSENGER_SEND_ALL', false),
        'callback_url' => env('MESSENGER_CALLBACK_URL'),
        'user_phone' => env('MESSENGER_USER_PHONE'),
    ],
    'smart-sender' => [
        'url' => env('SMART_SENDER_HOST'),
        'api-key' => env('SMART_SENDER_AUTHORIZATION'),
    ],
    'notify' => [
        'url' => env('NOTIFY_SERVICE_HOST'),
        'login' => env('NOTIFY_LOGIN'),
        'password' => env('NOTIFY_PASSWORD'),
        'profileUuid' => env('NOTIFY_PROFILE_UUID'),
    ],
];
