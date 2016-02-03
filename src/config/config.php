<?php return [
    
    /*
    |--------------------------------------------------------------------------
    | Custom Store
    |--------------------------------------------------------------------------
    | Select a custome cache store instead of the laravel default one.
    | will use default if set to '' or null
    |
    */
    'store' => '',

    /*
    |--------------------------------------------------------------------------
    | Cache default lifetime
    |--------------------------------------------------------------------------
    | How many minutes GuzzleCache will cache your request.
    | Scale to your application's needs.
    |
    */
    'lifetime' => 60,

    /*
    |--------------------------------------------------------------------------
    | Cache Prefix
    |--------------------------------------------------------------------------
    | GuzzleCache will Store the fetched url's whit a specific key prefix, which
    | you can customize here.
    |
    */
    'prefix' => 'guzzlecache_',

];
