<?php

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
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'r2' => [
        'key' => env('R2_ACCESS_KEY'),
        'secret' => env('R2_SECRET_KEY'),
        'bucket' => env('R2_BUCKET'),
        'endpoint' => env('R2_ENDPOINT'),
        'public_url' => env('R2_PUBLIC_URL'),
    ],
    'eps' => [
        'base_url'      => env('EPS_BASE_URL', env('EPSBaseURL')),
        'hash_key'      => env('EPS_HASH_KEY', env('EPSHashkey')),
        'username'      => env('EPS_USERNAME', env('EPSUserName')),
        'password'      => env('EPS_PASSWORD', env('EPSPassword')),
        'store_id'      => env('EPS_STORE_ID', env('EPSStoreID')),
        'merchant_id'   => env('EPS_MERCHANT_ID', env('EPSMerchentID')),
        'device_type'   => env('EPS_DEVICE_TYPE_ID', env('EPSDeviceTypeID')),
    ],

];
