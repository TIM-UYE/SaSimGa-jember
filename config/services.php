<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for all of the third party
    | services that you may use in your application. These services
    | may be used throughout your Laravel application without a lot of
    | friction.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Fonnte WhatsApp Service
    |--------------------------------------------------------------------------
    |
    | Configuration for Fonnte WhatsApp API service used for sending
    | order notifications to driver groups and customers.
    |
    */

    'fonnte' => [
        'token' => env('FONNTE_TOKEN'),
        'group_id' => env('FONNTE_GROUP_ID'),
    ],

];
