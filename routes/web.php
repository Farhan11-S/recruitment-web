<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CandidateController;

// ... route lainnya

// == AUTHENTICATION ROUTES ==

// Registrasi
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Login
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/', [LoginController::class, 'login']);

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// == APPLICATION ROUTES (DESTINATIONS) ==

// HRD Routes
Route::middleware(['auth', 'role:hrd'])->group(function () {
    Route::get('/hrd/dashboard', function () {
        return "Ini adalah Dashboard HRD";
    })->name('hrd.dashboard');
});

// Candidate Routes
Route::middleware(['auth', 'role:candidate'])->group(function () {
    Route::get('/kandidat/profil', [CandidateController::class, 'profile'])->name('candidate.profile');
});

// Catatan: 'role:hrd' dan 'role:candidate' adalah contoh nama middleware
// yang perlu Anda buat untuk proteksi route berdasarkan role.