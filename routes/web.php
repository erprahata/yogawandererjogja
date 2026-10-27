<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route catch-all untuk SPA Vue Router (Admin & Auth)
Route::get('/{any}', function () {
    return view('admin'); // Kita gunakan file blade yang sama untuk Auth & Admin
})->where('any', '^(admin|login|register|forgot-password).*$');
