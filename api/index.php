<?php

// Pastikan direktori storage di /tmp dibuat untuk lingkungan Vercel Serverless
$storageDirs = [
    '/tmp/views',
    '/tmp/framework/views',
    '/tmp/framework/cache',
    '/tmp/framework/sessions',
    '/tmp/logs',
];

foreach ($storageDirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// Forward ke entrypoint Laravel public/index.php
require __DIR__ . '/../public/index.php';
