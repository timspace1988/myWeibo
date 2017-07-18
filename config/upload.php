<?php

return [
    'storage' => env('CLOUD_STORAGE', 'local'),
    'webpath' => env('AWS_URL', '/upload'),
    //'webpath' => 'https://s3.us-east-2.amazonaws.com/jiablogheroku',
];
