<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BuktiController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\PenggajianController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});
Route::middleware(['auth'])->prefix('sdm')->group(function () {
    Route::resource('Karyawan', KaryawanController::class);
});

// Untuk user biasa
Route::middleware(['auth'])->prefix('kepala cabang')->group(function () {
    Route::resource('Bukti', BuktiController::class);
});

Route::middleware(['auth'])->prefix('keuangan')->group(function () {
    Route::resource('Users', UsersController::class);
    Route::resource('Karyawan', KaryawanController::class);
    Route::resource('Bukti', BuktiController::class);
    Route::resource('Penggajian', PenggajianController::class);
    Route::get('/gaji/karyawan/{id}', [PenggajianController::class, 'penggajian'])->name('Gaji.karyawan');
    Route::post('/gaji/karyawan/', [PenggajianController::class, 'store2'])->name('store2');
});


Route::get('/dashboard', [UsersController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/pph21/total', [PenggajianController::class, 'getTotal'])->name('pph21');
Route::get('/cetak/penggajian', [PenggajianController::class, 'cetak'])->name('cetak.penggajian');
Route::get('/cetak/karyawan', [KaryawanController::class, 'cetak'])->name('cetak.karyawan');
Route::get('/cetak/bukti', [BuktiController::class, 'cetak'])->name('cetak.bukti');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
