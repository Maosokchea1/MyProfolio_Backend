<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['https://my-profolio-mao-sokchea.online', 'http://localhost:5173'], // ใส่ Domain ជាក់ស្តែងរបស់អ្នកទាំង Local និង Vercel
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,
];