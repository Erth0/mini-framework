<?php

return [
    'name' => getenv('APP_NAME'),
    'app_url' => getenv('APP_URL'),
    'debug' => getenv('APP_DEBUG', false),

    'providers' => [
        '\App\Providers\AppServiceProvider',
        '\App\Providers\ViewServiceProvider',
        '\App\Providers\DatabaseServiceProvider',
        '\App\Providers\SessionServiceProvider',
        '\App\Providers\HashServiceProvider',
        '\App\Providers\AuthServiceProvider',
        '\App\Providers\FlashServiceProvider',
        '\App\Providers\ViewShareServiceProvider',
    ],

    'middleware' => [
        '\App\Middleware\ShareValidationErrors',
        '\App\Middleware\ClearValidationErrors',
        '\App\Middleware\Authenticate',
    ]
];