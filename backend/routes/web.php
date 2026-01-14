<?php

use Illuminate\Support\Facades\Route;

// Health check endpoint
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'message' => 'UCB Website API',
        'version' => '1.0.0',
    ]);
});

// Catch-all route untuk SPA frontend (fallback jika nginx tidak handle)
// Route ini akan di-handle oleh nginx, tapi sebagai backup
Route::get('/{any}', function () {
    $frontendPath = public_path('frontend/index.html');
    if (file_exists($frontendPath)) {
        return file_get_contents($frontendPath);
    }
    return response()->json([
        'message' => 'UCB Website API',
        'version' => '1.0.0',
    ]);
})->where('any', '^(?!api).*$');
