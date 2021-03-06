<?php

return [
    /*
    |--------------------------------------------------------------------------
    | The Host URI of the WordPress installation
    |--------------------------------------------------------------------------
    |
    | e.g. `https://local-wordpress.local/wp-json/wp/v2`
    |
    */
    'base_uri' => env('WPAPI_BASE_URI'),

    /*
    |--------------------------------------------------------------------------
    | The Request timeout
    |--------------------------------------------------------------------------
    |
    */
    'timeout' => env('WPAPI_TIMEOUT', 2.0),

    /*
    |--------------------------------------------------------------------------
    | The Responder
    |--------------------------------------------------------------------------
    |
    */
    'responder' => 'Jevets\WpApi\ArrayResponder',
];
