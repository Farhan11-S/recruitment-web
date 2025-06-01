<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\CandidateProfileController;
use App\Http\Controllers\DocumentController;

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

    Route::get('/kandidat/profil/edit', [CandidateProfileController::class, 'edit'])->name('candidate.profile.edit');
    Route::put('/kandidat/profil', [CandidateProfileController::class, 'update'])->name('candidate.profile.update');

    Route::get('/kandidat/dokumen/upload', [DocumentController::class, 'create'])->name('candidate.documents.create');
    Route::post('/kandidat/dokumen/upload', [DocumentController::class, 'store'])->name('candidate.documents.store');
});