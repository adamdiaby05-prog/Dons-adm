<?php

return [
    /*
    |--------------------------------------------------------------------------
    | FedaPay Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for FedaPay payment gateway integration
    |
    */

    'public_key' => env('FEDAPAY_PUBLIC_KEY'),
    'secret_key' => env('FEDAPAY_SECRET_KEY'),
    'environment' => env('FEDAPAY_ENVIRONMENT', 'live'),
    'base_url' => env('FEDAPAY_BASE_URL', 'https://api.fedapay.com/v1'),
];