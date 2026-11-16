<?php

// Pastikan file database sqlite di-copy ke /tmp saat runtime
$tmpDb = '/tmp/database.sqlite';
$sourceDb = __DIR__ . '/../database/database.sqlite';

if (!file_exists($tmpDb) && file_exists($sourceDb)) {
    @copy($sourceDb, $tmpDb);
}

// Forward to public entrypoint
require __DIR__ . '/../public/index.php';
