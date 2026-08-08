<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['*'], // អនុញ្ញាតគ្រប់ Domain ទាំងអស់មិនឱ្យជាប់ CORS ទៀតទេ
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false, // ប្រសិនបើប្រើ '*' ត្រូវប្តូរ supports_credentials មកជា false វិញ ទើប Laravel អនុញ្ញាត
];