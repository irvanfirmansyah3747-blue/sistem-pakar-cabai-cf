<?php

try {
    require __DIR__ . '/../vendor/autoload.php';
    $app = require_once __DIR__ . '/../bootstrap/app.php';

    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    $response = $kernel->handle(
        $request = Illuminate\Http\Request::capture()
    );
    $response->send();
    $kernel->terminate($request, $response);
} catch (\Throwable $e) {
    header('Content-Type: text/plain; charset=utf-8', true, 500);
    echo "=== ERROR LARAVEL TERDETEKSI ===\n";
    echo "Pesan: " . $e->getMessage() . "\n";
    echo "File : " . $e->getFile() . " baris " . $e->getLine() . "\n\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
    exit;
}
