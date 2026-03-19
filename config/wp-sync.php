<?php

return [

    'wp' => [
        'url'          => env('WP_URL'),
        'user'         => env('WP_USER'),
        'app_password' => env('WP_APP_PASSWORD'),
    ],

    'woo' => [
        'url'    => env('WOO_URL'),
        'key'    => env('WOO_KEY'),
        'secret' => env('WOO_SECRET'),
    ],

    'webhook_path' => env('WOO_WEBHOOK_PATH', 'woo/webhook'),

    'cache_ttl' => env('WP_SYNC_CACHE_TTL', 300),

    /*
    |--------------------------------------------------------------------------
    | Multi-site connections
    |--------------------------------------------------------------------------
    | Define additional named connections here and switch between them
    | at runtime using Wp::connection('name') or Woo::connection('name').
    */
    'connections' => [
        // 'store-de' => [
        //     'url'    => env('WOO_DE_URL'),
        //     'key'    => env('WOO_DE_KEY'),
        //     'secret' => env('WOO_DE_SECRET'),
        // ],
    ],

];
