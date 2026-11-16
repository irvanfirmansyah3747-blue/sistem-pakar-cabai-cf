<?php

use Illuminate\Support\Facades\Route;

// Test route untuk cek koneksi langsung
Route::get('/health', function () {
    try {
        \DB::connection()->getPdo();
        $tables = \DB::select('SHOW TABLES');
        return response()->json([
            'status' => 'OK',
            'database' => \DB::connection()->getDatabaseName(),
            'tables_count' => count($tables),
            'app_env' => config('app.env')
        ]);
    } catch (\Throwable $e) {
        return response()->json([
            'status' => 'ERROR',
            'error_message' => $e->getMessage(),
            'error_class' => get_class($e),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
});
