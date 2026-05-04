<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\TahunAnggaranController;
use Illuminate\Support\Facades\Route;

// ===================== LOGIN ===================== //
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ===================== GANTI TAHUN ANGGARAN ===================== //
Route::middleware('auth')->group(function () {
    Route::post('/tahun-anggaran/ganti', [TahunAnggaranController::class, 'ganti'])
        ->name('tahun-anggaran.ganti');
});

// ===================== REGISTER ===================== //
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('storeUser');
