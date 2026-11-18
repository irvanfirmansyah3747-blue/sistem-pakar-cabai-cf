<?php

echo "=== SIMULASI TAHAP 1: UJI KONEKSI TLS TIDB CLOUD ===\n";

$host = 'gateway01.ap-southeast-1.prod.aws.tidbcloud.com';
$port = 4000;
$db   = 'test';
$user = '3d7Dz8AAKfaYFe3.root';
$pass = 'H4dvXTBYgGwukop1';
$ca   = __DIR__ . '/../cert/cacert.pem';

if (!file_exists($ca)) {
    echo "[GAGAL] File cert/cacert.pem tidak ditemukan!\n";
    exit(1);
}

try {
    $dsn = "mysql:host={$host};port={$port};dbname={$db}";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_SSL_CA => $ca,
        PDO::ATTR_TIMEOUT => 10,
    ];

    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "[BERHASIL] Terhubung ke TiDB Cloud dengan enkripsi TLS!\n";

    // Cek versi MySQL/TiDB
    $version = $pdo->query('SELECT VERSION()')->fetchColumn();
    echo "  -> Versi Database Server : " . $version . "\n";

    $databases = $pdo->query('SHOW DATABASES')->fetchAll(PDO::FETCH_COLUMN);
    echo "  -> Daftar Database : " . implode(', ', $databases) . "\n";

    // Cek daftar tabel
    $tables = $pdo->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);
    echo "  -> Jumlah Tabel Saat Ini : " . count($tables) . "\n";
    if (count($tables) > 0) {
        echo "  -> Tabel: " . implode(', ', $tables) . "\n";
    }

} catch (\Throwable $e) {
    echo "[GAGAL] Terjadi Error Koneksi:\n";
    echo "  -> Pesan: " . $e->getMessage() . "\n";
    exit(1);
}
