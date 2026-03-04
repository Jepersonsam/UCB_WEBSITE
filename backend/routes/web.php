<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Route ini bertugas "menangkap" semua akses browser dan memberikan
| file Frontend (index.html), kecuali akses ke /api/*
|
*/

// 1. Halaman Depan (Root)
Route::get('/', function () {
    $path = public_path('index.html');
    if (file_exists($path)) {
        return file_get_contents($path);
    }
    return "File public/index.html tidak ditemukan. Pastikan Frontend sudah di-upload.";
});

// 2. Route Fallback (Untuk menangani refresh di halaman seperti /login, /admin, dll)
Route::fallback(function () {
    // Jika yang diakses adalah API tapi salah alamat, jangan kasih HTML (kasih 404 JSON)
    if (request()->is('api/*')) {
        return response()->json(['message' => 'API Route Not Found'], 404);
    }

    // Sisanya kasih Frontend
    $path = public_path('index.html');
    if (file_exists($path)) {
        return file_get_contents($path);
    }
    return "File public/index.html tidak ditemukan.";
});
