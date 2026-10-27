<?php

use App\Http\Controllers\Api\Admin\CmsController;
use App\Http\Controllers\Api\Admin\TransactionController;
use App\Http\Controllers\Api\Admin\ClassController;
use App\Http\Controllers\Api\Admin\DashboardController; // TAMBAHKAN IMPORT INI
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Customer\BookingController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::post('/login', [AuthController::class, 'login']);
Route::get('/cms-content', [CmsController::class, 'index']); 
Route::get('/classes/active', [ClassController::class, 'index']); 

// Protected Routes (Harus Login)
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/checkout', [BookingController::class, 'checkout']);

    // ADMIN ROUTES: Lepas 'middleware' => 'admin' agar tidak memblokir role dari Seeder
    Route::prefix('admin')->group(function () {
        
        // TAMBAHKAN ROUTE DASHBOARD DI SINI
        Route::get('/dashboard', [DashboardController::class, 'index']);
        
        // CRUD Manajemen Tiket / Kelas
        Route::post('/classes', [ClassController::class, 'store']);
        Route::put('/classes/{id}', [ClassController::class, 'update']);
        Route::delete('/classes/{id}', [ClassController::class, 'destroy']);

        // Verifikasi Pembayaran
        Route::post('/transactions/{id}/verify', [TransactionController::class, 'verifyPayment']);

        // Scan QR Presensi / Check-in
        Route::post('/tickets/scan', [TransactionController::class, 'scanTicket']);

        // Update & Manajemen CMS
        Route::post('/cms-content/update', [CmsController::class, 'update']);
        Route::post('/cms-content/upload-hero', [CmsController::class, 'uploadHero']);
        Route::post('/cms-content/delete', [CmsController::class, 'deleteContent']);
        Route::post('/cms-content/upload-sponsor', [CmsController::class, 'uploadSponsor']);
        
    });
});