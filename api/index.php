<?php

try {
    // Jalankan bootstrap Laravel manual dan tangkap exception mentah
    require __DIR__ . '/../vendor/autoload.php';
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    $response = $kernel->handle(
        $request = Illuminate\Http\Request::capture()
    );
    $response->send();
    $kernel->terminate($request, $response);
} catch (\Throwable $e) {
    header('Content-Type: text/plain; charset=utf-8', true, 200);
    echo "=== FATAL LARAVEL EXCEPTION CAPTURED ===\n";
    echo "CLASS   : " . get_class($e) . "\n";
    echo "MESSAGE : " . $e->getMessage() . "\n";
    echo "FILE    : " . $e->getFile() . ":" . $e->getLine() . "\n\n";
    echo "TRACE   :\n" . $e->getTraceAsString() . "\n";
}
