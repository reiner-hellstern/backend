<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => [
        'api/*',
        'storage/*',
        'login',
        'logout',
        'register',
        'user/password',
        'forgot-password',
        'reset-password',
        'sanctum/csrf-cookie',
        'user/profile-information',
        'email/verification-notification',
        'broadcasting/auth',  // CORS für Reverb Broadcasting Auth
    ],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'http://localhost:8080',
        'http://localhost:8000',
        'http://localhost',
        'https://localhost',
        'http://typo3v14',
        'https://drc-website.ddev.site',
        'https://drc-dev-api.atbloom.de',
        'https://drc-dev.atbloom.de',
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,

];
