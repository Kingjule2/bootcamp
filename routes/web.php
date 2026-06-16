<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// ── Auth Routes ──
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ── Offline fallback for PWA ──
Route::get('/offline-fallback', fn () => view('offline-fallback'))->name('offline');

// ── Protected Routes ──
Route::middleware(['auth'])->group(function () {

    // Root redirect based on role
    Route::get('/', [DashboardController::class, 'redirect']);

    // Panel 1: Dapur / Katering Mitra
    Route::prefix('dapur')->middleware('role:dapur')->group(function () {
        Route::get('/', fn () => view('dapur.dashboard'))->name('dapur.dashboard');
        Route::get('/produksi', fn () => view('dapur.produksi'))->name('dapur.produksi');
        Route::get('/pengiriman', fn () => view('dapur.pengiriman'))->name('dapur.pengiriman');
    });

    // Panel 2: Ahli Gizi / Verifikator
    Route::prefix('gizi')->middleware('role:ahli_gizi')->group(function () {
        Route::get('/', fn () => view('gizi.dashboard'))->name('gizi.dashboard');
        Route::get('/riwayat', fn () => view('gizi.riwayat'))->name('gizi.riwayat');
    });

    // Panel 3: Sekolah & Driver (Kurir)
    Route::prefix('sekolah')->middleware('role:sekolah')->group(function () {
        Route::get('/', fn () => view('sekolah.dashboard'))->name('sekolah.dashboard');
        Route::post('/sync-offline', [App\Http\Controllers\OfflineSyncController::class, 'syncOffline']);
    });

    Route::prefix('kurir')->middleware('role:kurir')->group(function () {
        Route::get('/', fn () => view('kurir.dashboard'))->name('kurir.dashboard');
    });

    // Panel 4: Admin Dinas
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        Route::get('/', fn () => view('admin.dashboard'))->name('admin.dashboard');
    });
});
