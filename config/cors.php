<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    // ជំនួសសញ្ញាផ្កាយ '*' ដោយដាក់ Domain របស់ Frontend របស់អ្នកនៅលើ Vercel
    'allowed_origins' => [
    'https://my-profolio-mao-sokchea.online',
    'https://my-profolio-mao-sokchea.vercel.app'
],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    // ប្តូរពី false មកជា true ដើម្បីឱ្យវាទទួលយក Cookie ឬ Authentication tokens
    'supports_credentials' => true,
];