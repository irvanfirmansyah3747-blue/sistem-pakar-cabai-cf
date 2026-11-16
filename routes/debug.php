<?php

use Illuminate\Support\Facades\Route;

// Endpoint diagnosa untuk melihat error asli secara aman
Route::get('/debug-error', function () {
    try {
        // Cek database
        $pdo = \DB::connection()->getPdo();
        $dbName = \DB::connection()->getDatabaseName();
        $userCount = \App\Models\User::count();
        return response()->json([
            'status' => 'SUCCESS',
            'database' => $dbName,
            'users' => $userCount,
            'session_driver' => config('session.driver'),
            'cache_store' => config('cache.default'),
        ]);
    } catch (\Throwable $e) {
        return response()->json([
            'status' => 'DATABASE_OR_APP_ERROR',
            'message' => $e->getMessage(),
            'file' => $e->getFile() . ':' . $e->getLine(),
            'trace' => explode("\n", $e->getTraceAsString())
        ], 200);
    }
});
