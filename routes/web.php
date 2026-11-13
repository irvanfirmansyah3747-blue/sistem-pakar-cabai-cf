<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PetakController;
use App\Http\Controllers\PenyakitController;
use App\Http\Controllers\GejalaController;
use App\Http\Controllers\RuleController;
use App\Http\Controllers\DiagnosaController;
use App\Http\Controllers\TindakanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\KaryawanController;

// Halaman Depan & Otentikasi
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/quick-login/{role}', [AuthController::class, 'quickLogin'])->name('quick.login');

// Area Terproteksi (Login Diperlukan)
Route::middleware(['auth'])->group(function () {
    // Dashboard (Dinamis: Tampilan Pengawas vs Karyawan)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Konsultasi & Riwayat Diagnosa (Bisa diakses Pengawas & Karyawan)
    Route::get('/diagnosa', [DiagnosaController::class, 'index'])->name('diagnosa.index');
    Route::get('/diagnosa/mulai', [DiagnosaController::class, 'create'])->name('diagnosa.create');
    Route::post('/diagnosa', [DiagnosaController::class, 'store'])->name('diagnosa.store');
    Route::get('/diagnosa/{diagnosa}', [DiagnosaController::class, 'show'])->name('diagnosa.show');
    Route::delete('/diagnosa/{diagnosa}', [DiagnosaController::class, 'destroy'])->name('diagnosa.destroy')->middleware('role:pengawas');

    // Petak Semai (Karyawan bisa melihat lokasi dan detail, Pengawas bisa mengelola)
    Route::get('/petaks', [PetakController::class, 'index'])->name('petaks.index');
    Route::get('/petaks/{petak}', [PetakController::class, 'show'])->name('petaks.show');

    // Penyakit & Gejala (Karyawan bisa melihat ensiklopedia)
    Route::get('/penyakits', [PenyakitController::class, 'index'])->name('penyakits.index');
    Route::get('/penyakits/{penyakit}', [PenyakitController::class, 'show'])->name('penyakits.show');

    // Tindakan / Instruksi Penanganan
    Route::get('/tindakans', [TindakanController::class, 'index'])->name('tindakans.index');
    Route::patch('/tindakans/{tindakan}/status', [TindakanController::class, 'updateStatus'])->name('tindakans.update-status');

    // KHUSUS ROLE: PENGAWAS (HAK PENUH)
    Route::middleware(['role:pengawas'])->group(function () {
        // Kelola Petak Semai
        Route::get('/petaks-baru', [PetakController::class, 'create'])->name('petaks.create');
        Route::post('/petaks', [PetakController::class, 'store'])->name('petaks.store');
        Route::get('/petaks/{petak}/edit', [PetakController::class, 'edit'])->name('petaks.edit');
        Route::put('/petaks/{petak}', [PetakController::class, 'update'])->name('petaks.update');
        Route::patch('/petaks/{petak}/verifikasi-sehat', [PetakController::class, 'verifikasiSehat'])->name('petaks.verifikasi-sehat');
        Route::delete('/petaks/{petak}', [PetakController::class, 'destroy'])->name('petaks.destroy');

        // Kelola Master Penyakit
        Route::get('/penyakits-baru', [PenyakitController::class, 'create'])->name('penyakits.create');
        Route::post('/penyakits', [PenyakitController::class, 'store'])->name('penyakits.store');
        Route::get('/penyakits/{penyakit}/edit', [PenyakitController::class, 'edit'])->name('penyakits.edit');
        Route::put('/penyakits/{penyakit}', [PenyakitController::class, 'update'])->name('penyakits.update');
        Route::delete('/penyakits/{penyakit}', [PenyakitController::class, 'destroy'])->name('penyakits.destroy');

        // Kelola Master Gejala
        Route::resource('gejalas', GejalaController::class)->except(['show']);

        // Kelola Basis Aturan & Bobot Certainty Factor Pakar
        Route::get('/rules', [RuleController::class, 'index'])->name('rules.index');
        Route::post('/rules', [RuleController::class, 'store'])->name('rules.store');
        Route::put('/rules/{rule}', [RuleController::class, 'update'])->name('rules.update');
        Route::delete('/rules/{rule}', [RuleController::class, 'destroy'])->name('rules.destroy');

        // Kelola Akun Karyawan
        Route::resource('karyawan', KaryawanController::class)->except(['show']);

        // Buat Instruksi Tindakan
        Route::get('/tindakans-baru', [TindakanController::class, 'create'])->name('tindakans.create');
        Route::post('/tindakans', [TindakanController::class, 'store'])->name('tindakans.store');

        // Laporan Statistik & Analisis Sebaran Penyakit
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak');
    });
});
