<?php declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain'   => env('MAILGUN_DOMAIN'),
        'secret'   => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme'   => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key'    => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'token'  => env('AWS_SESSION_TOKEN'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'google' => [
        'maps'        => [
            'key' => env('GOOGLE_MAPS_API_KEY'),
        ],
        'recaptcha'   => [
            'uri' => 'https://www.google.com/recaptcha/api/siteverify',
            'v2'  => [
                'site-key' => env('GOOGLE_RECAPTCHA_SITE_KEY_V2'),
                'secret'   => env('GOOGLE_RECAPTCHA_SECRET_V2'),
            ],
            'v3'  => [
                'site-key' => env('GOOGLE_RECAPTCHA_SITE_KEY_V3'),
                'secret'   => env('GOOGLE_RECAPTCHA_SECRET_V3'),
            ],
        ],
        'tag-manager' => [
            'key' => env('GOOGLE_TAG_MANAGER_KEY'),
        ],
    ],

];
