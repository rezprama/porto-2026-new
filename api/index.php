<?php

// Prepare writable directories in /tmp for Vercel Serverless environment
$dirs = [
    '/tmp/storage/app',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
];

foreach ($dirs as $dir) {
    if (! is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

if (! file_exists('/tmp/database.sqlite')) {
    touch('/tmp/database.sqlite');
}

// Forward request to Laravel public entrypoint
require __DIR__.'/../public/index.php';
