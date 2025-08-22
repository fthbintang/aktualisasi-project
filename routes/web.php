<?php

use App\Http\Controllers\DaftarLaporanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;

Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/sign-in', [LoginController::class, 'authenticate'])->name('authentication');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // PENGGUNA
    Route::get('/dashboard/pengguna', [UserController::class, 'index'])->name('pengguna.index');
    Route::get('/dashboard/pengguna/create', [UserController::class, 'create'])->name('pengguna.create');
    Route::post('/dashboard/pengguna/create/store', [UserController::class, 'store'])->name('pengguna.store');
    Route::get('/dashboard/pengguna/edit/{user}', [UserController::class, 'edit'])->name('pengguna.edit');
    Route::put('/dashboard/pengguna/edit/{user}/update', [UserController::class, 'update'])->name('pengguna.update');
    Route::delete('/dashboard/pengguna/destroy/{user}', [UserController::class, 'destroy'])->name('pengguna.destroy');

    // LAPORAN
    Route::get('/dashboard/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::patch('/dashboard/laporan/{id}/toggle', [LaporanController::class, 'toggle'])->name('laporan.toggle');
    
    Route::get('/dashboard/laporan/laporan_tahun/create', [LaporanController::class, 'create'])->name('laporan_tahun.create');
    Route::post('/dashboard/laporan/laporan_tahun/store', [LaporanController::class, 'store'])->name('laporan_tahun.store');
    Route::delete('/dashboard/laporan/laporan_tahun/{laporan}/{tahun}', [LaporanController::class, 'destroy'])->name('laporan_tahun.destroy');

    // DAFTAR LAPORAN
    Route::get('/dashboard/daftar_laporan', [DaftarLaporanController::class, 'index'])->name('daftar_laporan.index');
    Route::get('/dashboard/daftar_laporan/create_jenis_laporan', [DaftarLaporanController::class, 'create_jenis_laporan'])->name('daftar_laporan.create_jenis_laporan');
    Route::post('/dashboard/daftar_laporan/create_jenis_laporan/store', [DaftarLaporanController::class, 'store_jenis_laporan'])->name('daftar_laporan.store_jenis_laporan');
    Route::get('/dashboard/daftar_laporan/edit_jenis_laporan/{id}', [DaftarLaporanController::class, 'editJenis'])->name('daftar_laporan.edit_jenis_laporan');
    Route::put('/dashboard/daftar_laporan/edit_jenis_laporan/{jenis_laporan}/update', [DaftarLaporanController::class, 'update_jenis_laporan'])->name('daftar_laporan.update_jenis_laporan');
    Route::get('/dashboard/daftar_laporan/create_laporan', [DaftarLaporanController::class, 'create_laporan'])->name('daftar_laporan.create_laporan');
    Route::post('/dashboard/daftar_laporan/create_laporan/store', [DaftarLaporanController::class, 'store_laporan'])->name('daftar_laporan.store_laporan');
    Route::get('/dashboard/daftar_laporan/edit_laporan/{id}', [DaftarLaporanController::class, 'editLaporan'])->name('daftar_laporan.edit_laporan');
    Route::put('/dashboard/daftar_laporan/edit_laporan/{laporan}/update', [DaftarLaporanController::class, 'update_laporan'])->name('daftar_laporan.update_laporan');
    Route::delete('/dashboard/daftar_laporan/{laporan}/destroy', [DaftarLaporanController::class, 'destroy_laporan'])->name('daftar_laporan.destroy_laporan');
    Route::delete('/dashboard/daftar_laporan/jenis/{jenis_laporan}/destroy', [DaftarLaporanController::class, 'destroy_jenis_laporan'])->name('daftar_laporan.destroy_jenis_laporan');
});