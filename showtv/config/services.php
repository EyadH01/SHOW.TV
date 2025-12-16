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

    'youtube' => [
        'api_key' => env('YOUTUBE_API_KEY'),
        'channel_id' => env('YOUTUBE_CHANNEL_ID', 'UCwWhs_6x42TyRM4w_-phweA'),
    ],

    'shahed' => [
        'api_key' => env('SHAHED_API_KEY'),
        'base_url' => env('SHAHED_BASE_URL', 'https://api.shahed.tv/v1'),
        'client_id' => env('SHAHED_CLIENT_ID'),
        'client_secret' => env('SHAHED_CLIENT_SECRET'),
    ],

    'tmdb' => [
        'api_key' => env('TMDB_API_KEY'),
        'base_url' => env('TMDB_BASE_URL', 'https://api.themoviedb.org/3'),
        'image_base_url' => env('TMDB_IMAGE_BASE_URL', 'https://image.tmdb.org/t/p'),
    ],

    'google' => [
        'images_api_key' => env('GOOGLE_IMAGES_API_KEY'),
        'search_engine_id' => env('GOOGLE_SEARCH_ENGINE_ID'),
    ],

];
