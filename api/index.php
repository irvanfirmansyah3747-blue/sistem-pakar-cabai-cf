<?php

// Direct probe untuk melihat error spesifik dari Vercel
error_reporting(E_ALL);
ini_set('display_errors', '1');

header('Content-Type: text/plain; charset=utf-8');
echo "=== VERCEL PHP RUNTIME DIAGNOSTIC ===\n";
echo "PHP Version: " . PHP_VERSION . "\n";
echo "Loaded Extensions: " . implode(', ', get_loaded_extensions()) . "\n\n";

try {
    require __DIR__ . '/../vendor/autoload.php';
    echo "Autoload: SUCCESS\n";
    
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    echo "Bootstrap App: SUCCESS\n";
    
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    echo "Make Kernel: SUCCESS\n";
    
    $request = Illuminate\Http\Request::create('/login', 'GET');
    $response = $kernel->handle($request);
    echo "Handle Request: SUCCESS (" . $response->getStatusCode() . ")\n";
    
} catch (\Throwable $e) {
    echo "!!! EXCEPTION TERDETEKSI !!!\n";
    echo "Type   : " . get_class($e) . "\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "File   : " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "Trace  :\n" . $e->getTraceAsString() . "\n";
}
exit;
