<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

// Konfigurasikan env TiDB Cloud sama persis seperti di Vercel
config([
    'database.default' => 'mysql',
    'database.connections.mysql.host' => 'gateway01.ap-southeast-1.prod.aws.tidbcloud.com',
    'database.connections.mysql.port' => 4000,
    'database.connections.mysql.database' => 'test',
    'database.connections.mysql.username' => '3d7Dz8AAKfaYFe3.root',
    'database.connections.mysql.password' => 'H4dvXTBYgGwukop1',
    'database.connections.mysql.options' => [
        PDO::MYSQL_ATTR_SSL_CA => realpath(__DIR__ . '/../cert/cacert.pem'),
    ],
]);

Illuminate\Support\Facades\DB::purge('mysql');

echo "=== SIMULASI REQUEST HTTP LARAVEL DENGAN TIDB CLOUD ===\n";

// Simulasi Request GET ke halaman utama / login
$request = Illuminate\Http\Request::create('/login', 'GET');
$response = $kernel->handle($request);

echo "Status Code /login : " . $response->getStatusCode() . "\n";
if ($response->getStatusCode() === 200) {
    echo "[BERHASIL] Halaman Login sukses dimuat dengan koneksi TiDB Cloud!\n";
} else {
    echo "[GAGAL] Status: " . $response->getStatusCode() . "\n";
    echo substr($response->getContent(), 0, 500) . "\n";
}

// Simulasi Query View v_rekap_sebaran_penyakit
try {
    $viewData = Illuminate\Support\Facades\DB::connection('mysql')->table('v_rekap_sebaran_penyakit')->get();
    echo "\n=== QUERY VIEW v_rekap_sebaran_penyakit ===\n";
    echo "[BERHASIL] View MySQL berhasil di-query tanpa error!\n";
    echo "Jumlah baris data view saat ini: " . $viewData->count() . "\n";
} catch (\Throwable $e) {
    echo "[GAGAL] Error query view: " . $e->getMessage() . "\n";
}

$kernel->terminate($request, $response);
