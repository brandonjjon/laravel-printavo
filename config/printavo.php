<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Printavo API Credentials
    |--------------------------------------------------------------------------
    |
    | Your Printavo account email and API token. These can be found in your
    | Printavo account settings under API Access.
    |
    */

    'email' => env('PRINTAVO_EMAIL'),

    'token' => env('PRINTAVO_TOKEN'),

    /*
    |--------------------------------------------------------------------------
    | API Endpoint
    |--------------------------------------------------------------------------
    |
    | The Printavo GraphQL API endpoint. You should not need to change this
    | unless Printavo changes their API URL.
    |
    */

    'endpoint' => env('PRINTAVO_ENDPOINT', 'https://www.printavo.com/api/v2'),

    /*
    |--------------------------------------------------------------------------
    | Response Caching
    |--------------------------------------------------------------------------
    |
    | Enable caching of API responses to reduce the number of requests made
    | and improve performance. The TTL (time-to-live) is specified in seconds.
    |
    | Options:
    | - enabled: Set to false to disable caching entirely (useful for debugging)
    | - ttl: Time-to-live in seconds (default: 300 = 5 minutes)
    | - store: Cache store to use (null = default store). Use 'redis' or
    |          'memcached' for cache tagging support, which enables selective
    |          cache flushing via flushCache().
    |
    */

    'cache' => [
        'enabled' => env('PRINTAVO_CACHE_ENABLED', true),
        'ttl' => env('PRINTAVO_CACHE_TTL', 300),
        'store' => env('PRINTAVO_CACHE_STORE'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    |
    | Printavo's API is limited to 10 requests per 5 seconds per email/IP.
    | These settings configure the rate limiter to respect those limits.
    |
    | Options:
    | - requests: Maximum requests allowed per window (default: 10)
    | - seconds: Window duration in seconds (default: 5)
    | - behavior: What to do when limit is reached:
    |     - 'wait': Sleep until a request slot is available (default, best for queued jobs)
    |     - 'throw': Throw RateLimitException immediately (best for real-time requests)
    |
    */

    'rate_limit' => [
        'requests' => env('PRINTAVO_RATE_LIMIT_REQUESTS', 10),
        'seconds' => env('PRINTAVO_RATE_LIMIT_SECONDS', 5),
        'behavior' => env('PRINTAVO_RATE_LIMIT_BEHAVIOR', 'wait'),
    ],

];
