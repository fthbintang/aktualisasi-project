<?php

use App\Http\Controllers\ArsipGugatanController;
use App\Http\Controllers\ArsipPermohonanController;
use App\Http\Controllers\ArsipPidanaController;
use App\Http\Controllers\DaftarLaporanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LaporanPerdataController;
use App\Http\Controllers\LaporanPidanaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;

Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/sign-in', [LoginController::class, 'authenticate'])->name('authentication');
});

Route::middleware(['auth', 'role:Kepaniteraan Hukum'])->group(function () {
    // PENGGUNA
    Route::get('/dashboard/pengguna', [UserController::class, 'index'])->name('pengguna.index');
    Route::get('/dashboard/pengguna/create', [UserController::class, 'create'])->name('pengguna.create');
    Route::post('/dashboard/pengguna/create/store', [UserController::class, 'store'])->name('pengguna.store');
    Route::get('/dashboard/pengguna/edit/{user}', [UserController::class, 'edit'])->name('pengguna.edit');
    Route::put('/dashboard/pengguna/edit/{user}/update', [UserController::class, 'update'])->name('pengguna.update');
    Route::delete('/dashboard/pengguna/destroy/{user}', [UserController::class, 'destroy'])->name('pengguna.destroy');

    // LAPORAN
    // Route::patch('/dashboard/laporan/{id}/toggle', [LaporanController::class, 'toggle'])->name('laporan.toggle');
    Route::get('/dashboard/laporan/laporan_tahun/create', [LaporanController::class, 'create'])->name('laporan_tahun.create');
    Route::post('/dashboard/laporan/laporan_tahun/store', [LaporanController::class, 'store'])->name('laporan_tahun.store');
    Route::delete('/dashboard/laporan/laporan_tahun/{laporan}/{tahun}', [LaporanController::class, 'destroy'])->name('laporan_tahun.destroy');

    Route::post('/dashboard/laporan/upload_laporan', [LaporanController::class, 'upload_laporan'])->name('upload_laporan.store');
    Route::put('/dashboard/laporan/update_laporan/{uploadLaporan}', [LaporanController::class, 'update_laporan'])->name('upload_laporan.update');
    Route::delete('/dashboard/laporan/upload_laporan/{uploadLaporan}', [LaporanController::class, 'delete_laporan'])->name('upload_laporan.delete');

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

    // ARSIP PERMOHONAN
    Route::get('/dashboard/arsip_permohonan/create', [ArsipPermohonanController::class, 'create'])->name('arsip_permohonan.create');
    Route::post('/dashboard/arsip_permohonan/store', [ArsipPermohonanController::class, 'store'])->name('arsip_permohonan.store');
    Route::get('/dashboard/arsip_permohonan/edit/{arsip_permohonan}', [ArsipPermohonanController::class, 'edit'])->name('arsip_permohonan.edit');
    Route::put('/dashboard/arsip_permohonan/update/{arsip_permohonan}', [ArsipPermohonanController::class, 'update'])->name('arsip_permohonan.update');
    Route::delete('/dashboard/arsip_permohonan/destroy/{arsip_permohonan}', [ArsipPermohonanController::class, 'destroy'])->name('arsip_permohonan.destroy');

    // ARSIP GUGATAN
    Route::get('/dashboard/arsip_gugatan/create', [ArsipGugatanController::class, 'create'])->name('arsip_gugatan.create');
    Route::get('/dashboard/arsip_gugatan/edit/{arsip_gugatan}', [ArsipGugatanController::class, 'edit'])->name('arsip_gugatan.edit');
    Route::put('/dashboard/arsip_gugatan/edit/{arsip_gugatan}', [ArsipGugatanController::class, 'update'])->name('arsip_gugatan.update');
    Route::post('/dashboard/arsip_gugatan/store', [ArsipGugatanController::class, 'store'])->name('arsip_gugatan.store');
    Route::delete('/dashboard/arsip_gugatan/destroy/{arsip_gugatan}', [ArsipGugatanController::class, 'destroy'])->name('arsip_gugatan.destroy');

    // ARSIP PIDANA
    Route::get('/dashboard/arsip_pidana/create', [ArsipPidanaController::class, 'create'])->name('arsip_pidana.create');
    Route::get('/dashboard/arsip_pidana/edit/{arsip_pidana}', [ArsipPidanaController::class, 'edit'])->name('arsip_pidana.edit');
    Route::post('/dashboard/arsip_pidana/store', [ArsipPidanaController::class, 'store'])->name('arsip_pidana.store');
    Route::put('/dashboard/arsip_pidana/update/{arsip_pidana}', [ArsipPidanaController::class, 'update'])->name('arsip_pidana.update');
    Route::delete('/dashboard/arsip_pidana/destroy/{arsip_pidana}', [ArsipPidanaController::class, 'destroy'])->name('arsip_pidana.destroy');
});

Route::middleware(['auth', 'role:Kepaniteraan Hukum,Kepaniteraan Pidana,Kepaniteraan Perdata, Panitera, Ketua PN'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // LAPORAN
    Route::get('/dashboard/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/dashboard/laporan/{tahun}/{bulan}/download', [LaporanController::class, 'downloadZip'])->name('laporan.downloadZip');

    // ARSIP PERMOHONAN
    Route::get('/dashboard/arsip-permohonan/data', [ArsipPermohonanController::class, 'getData'])->name('arsip_permohonan.data');
    Route::get('/dashboard/arsip_permohonan', [ArsipPermohonanController::class, 'index'])->name('arsip_permohonan.index');

    // ARSIP GUGATAN
    Route::get('/dashboard/arsip-gugatan/data', [ArsipGugatanController::class, 'getData'])->name('arsip_gugatan.data');
    Route::get('/dashboard/arsip_gugatan', [ArsipGugatanController::class, 'index'])->name('arsip_gugatan.index');

    // ARSIP PIDANA
    Route::get('/dashboard/arsip-pidana/data', [ArsipPidanaController::class, 'getData'])->name('arsip_pidana.data');
    Route::get('/dashboard/arsip_pidana', [ArsipPidanaController::class, 'index'])->name('arsip_pidana.index');
});

Route::middleware(['auth', 'role:Kepaniteraan Hukum,Kepaniteraan Perdata, Panitera, Ketua PN'])->group(function () {
    // LAPORAN PERDATA
    Route::get('/dashboard/laporan_perdata', [LaporanPerdataController::class, 'index'])->name('laporan_perdata.index');
    Route::post('/dashboard/laporan_perdata/store', [LaporanPerdataController::class, 'store'])->name('laporan_perdata.store');
    Route::put('/dashboard/laporan_perdata/update/{laporan_perdata_detail}', [LaporanPerdataController::class, 'update'])->name('laporan_perdata.update');
    Route::delete('/dashboard/laporan_perdata/destroy/{laporan_perdata_detail}', [LaporanPerdataController::class, 'destroy'])->name('laporan_perdata.destroy');
    Route::get('/dashboard/laporan_perdata/download-all', [LaporanPerdataController::class, 'downloadAll'])->name('laporan_perdata.download_all');
});

Route::middleware(['auth', 'role:Kepaniteraan Hukum,Kepaniteraan Pidana, Panitera, Ketua PN'])->group(function () {
    // LAPORAN PIDANA
    Route::get('/dashboard/laporan_pidana', [LaporanPidanaController::class, 'index'])->name('laporan_pidana.index');
    Route::post('/dashboard/laporan_pidana/store', [LaporanPidanaController::class, 'store'])->name('laporan_pidana.store');
});