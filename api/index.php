<?php

// Forward all Vercel serverless requests to normal Laravel public entrypoint
$tmpDb = '/tmp/database.sqlite';
$sourceDb = __DIR__ . '/../database/database.sqlite';

if (!file_exists($tmpDb) && file_exists($sourceDb)) {
    @copy($sourceDb, $tmpDb);
}

require __DIR__ . '/../public/index.php';
