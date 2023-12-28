<?php declare(strict_types=1);

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

    'paths' => [ 'api/*', 'sanctum/csrf-cookie' ],

    'allowed_methods' => [ '*' ],

    'allowed_origins' => array_reduce([ 'http', 'https' ], static fn($carry, $protocol) =>
        array_merge($carry, array_map(
            static fn($domain) => "$protocol://$domain",
            explode(',', env('CORS_ALLOWED_ORIGINS', ''))
        )), []),

    'allowed_origins_patterns' => [],

    'allowed_headers' => [ '*' ],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,

];
