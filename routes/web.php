<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Candidate\ApplicationController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\CandidateProfileController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\HRD\JobVacancyController as HrdJobVacancyController;
use App\Http\Controllers\JobVacancyController;

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
Route::middleware(['auth', 'role:hrd'])->prefix('hrd')->name('hrd.')->group(function () {
    Route::get('/dashboard', function() {
        return "Ini adalah halaman Dashboard HRD";
    })->name('dashboard');

    Route::resource('lowongan', HrdJobVacancyController::class)->names('job_vacancies');
});

// Candidate Routes
Route::middleware(['auth', 'role:candidate'])->group(function () {
    Route::get('/kandidat/profil', [CandidateController::class, 'profile'])->name('candidate.profile');

    // Edit Profile
    Route::get('/kandidat/profil/edit', [CandidateProfileController::class, 'edit'])->name('candidate.profile.edit');
    Route::put('/kandidat/profil', [CandidateProfileController::class, 'update'])->name('candidate.profile.update');

    // Upload CV
    Route::get('/kandidat/profil/upload-cv', [CandidateProfileController::class, 'editResume'])->name('candidate.resume.edit');
    Route::patch('/kandidat/profil/upload-cv', [CandidateProfileController::class, 'updateResume'])->name('candidate.resume.update');

    // Lowongan Pekerjaan
    Route::get('/lowongan-pekerjaan', [JobVacancyController::class, 'index'])->name('job_vacancies.index');
    Route::get('/lowongan-pekerjaan/{jobVacancy}', [JobVacancyController::class, 'show'])->name('job_vacancies.show');
    Route::post('/lowongan-pekerjaan/{jobVacancy}/lamar', [JobVacancyController::class, 'apply'])
        ->middleware(['auth', 'role:candidate'])
        ->name('job_vacancies.apply');

    // Lamaran
    Route::get('/kandidat/lamaran/{application}', [ApplicationController::class, 'show'])->name('candidate.applications.show');
    Route::post('/kandidat/lamaran/{application}/dokumen', [ApplicationController::class, 'storeDocument'])->name('candidate.applications.storeDocument');
});
