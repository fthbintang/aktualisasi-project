<?php

use App\Http\Controllers\DashboardController;
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
});