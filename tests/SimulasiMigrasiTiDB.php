<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Set database config ke TiDB Cloud
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

echo "=== MENJALANKAN MIGRASI & SEEDING KE TIDB CLOUD ===\n";
Illuminate\Support\Facades\Artisan::call('migrate:fresh', [
    '--seed' => true,
    '--force' => true,
]);
echo Illuminate\Support\Facades\Artisan::output();

// Verifikasi isi tabel di TiDB Cloud
$tables = Illuminate\Support\Facades\DB::connection('mysql')->select('SHOW TABLES');
echo "\n=== DAFTAR TABEL DI TIDB CLOUD SETELAH MIGRASI ===\n";
foreach ($tables as $t) {
    $arr = (array)$t;
    echo " - " . reset($arr) . "\n";
}

$userCount = Illuminate\Support\Facades\DB::connection('mysql')->table('users')->count();
$penyakitCount = Illuminate\Support\Facades\DB::connection('mysql')->table('penyakits')->count();
$gejalaCount = Illuminate\Support\Facades\DB::connection('mysql')->table('gejalas')->count();
$ruleCount = Illuminate\Support\Facades\DB::connection('mysql')->table('rules')->count();

echo "\n=== VERIFIKASI DATA SEEDER ===\n";
echo " - Total Users    : {$userCount}\n";
echo " - Total Penyakit : {$penyakitCount}\n";
echo " - Total Gejala   : {$gejalaCount}\n";
echo " - Total Rules    : {$ruleCount}\n";

// Verifikasi View
$viewCheck = Illuminate\Support\Facades\DB::connection('mysql')->select("SHOW FULL TABLES WHERE Table_type = 'VIEW'");
echo "\n=== VERIFIKASI VIEW MYSQL ===\n";
foreach ($viewCheck as $v) {
    $arr = (array)$v;
    echo " - View: " . reset($arr) . "\n";
}
