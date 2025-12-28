<?php

use Illuminate\Support\Facades\Route;

// SPA route - semua route frontend diarahkan ke app.blade.php
// Exclude storage and api routes
Route::get('/{any}', function () {
    return view('app');
})->where('any', '^(?!storage|api).*');
