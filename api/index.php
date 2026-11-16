<?php

// Jalankan file native sebelum bootstrap Laravel untuk membaca error asli
if (isset($_GET['info'])) {
    phpinfo();
    exit;
}

if (isset($_GET['testdb'])) {
    try {
        $host = getenv('DB_HOST');
        $port = getenv('DB_PORT') ?: 3306;
        $db = getenv('DB_DATABASE');
        $user = getenv('DB_USERNAME');
        $pass = getenv('DB_PASSWORD');

        $pdo = new PDO("mysql:host=$host;port=$port;dbname=$db", $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_SSL_CA => true,
        ]);
        echo "DATABASE OK: " . $db;
    } catch (\Throwable $e) {
        echo "DATABASE ERROR: " . $e->getMessage();
    }
    exit;
}

// Forward all Vercel serverless requests to normal Laravel public entrypoint
require __DIR__ . '/../public/index.php';
