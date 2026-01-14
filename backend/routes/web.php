<?php

use Illuminate\Support\Facades\Route;

// Backend hanya serve API, frontend di-handle terpisah
// Route ini bisa digunakan untuk health check atau redirect jika diperlukan
Route::get('/', function () {
    return response()->json([
        'message' => 'UCB Website API',
        'version' => '1.0.0',
        'docs' => '/api/v1',
    ]);
});
