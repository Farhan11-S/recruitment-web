<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use App\Models\JobVacancy;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class JobVacancyController extends Controller
{
    /**
     * Menampilkan daftar semua lowongan pekerjaan yang masih buka.
     */
    public function index()
    {
        $vacancies = JobVacancy::where('status', 'open')
            ->where(function ($query) {
                $query->where('deadline_at', '>=', Carbon::now())
                    ->orWhereNull('deadline_at');
            })
            ->latest() // Tampilkan yang terbaru di atas
            ->paginate(10); // Gunakan paginasi

        return view('job_vacancies.index', compact('vacancies'));
    }

    /**
     * Menampilkan detail dari satu lowongan pekerjaan.
     *
     * @param \App\Models\JobVacancy $jobVacancy
     * @return \Illuminate\View\View
     */
    public function show(JobVacancy $jobVacancy)
    {
        $hasApplied = false;
        // Cek apakah user login dan merupakan kandidat
        if (Auth::check() && Auth::user()->role === 'candidate') {
            // Cek apakah kandidat ini sudah pernah melamar ke lowongan ini
            $hasApplied = Application::where('user_id', Auth::id())
                ->where('job_vacancy_id', $jobVacancy->id)
                ->exists();
        }

        return view('job_vacancies.show', compact('jobVacancy', 'hasApplied'));
    }

    /**
     * Memproses lamaran dari seorang kandidat untuk lowongan spesifik.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\JobVacancy $jobVacancy
     * @return \Illuminate\Http\RedirectResponse
     */
    public function apply(Request $request, JobVacancy $jobVacancy)
    {
        $user = Auth::user();

        // 1. Validasi Keamanan & Aturan Bisnis
        // Cek apakah profil kandidat sudah lengkap
        if (!$user->candidateProfile?->is_complete || !$user->candidateProfile?->resume_path) {
            return redirect()->route('candidate.profile')->with('error', 'Harap lengkapi data diri dan unggah CV utama Anda terlebih dahulu sebelum melamar.');
        }

        // Cek lagi untuk memastikan kandidat belum pernah melamar (double check)
        $hasApplied = Application::where('user_id', $user->id)
                                 ->where('job_vacancy_id', $jobVacancy->id)
                                 ->exists();

        if ($hasApplied) {
            return back()->with('error', 'Anda sudah pernah melamar untuk posisi ini.');
        }

        // 2. Buat record lamaran baru
        $newApplication = Application::create([
            'user_id' => $user->id,
            'job_vacancy_id' => $jobVacancy->id,
            'status' => 'belum_lengkap', // Status awal, kandidat mungkin perlu upload dokumen spesifik
        ]);

        // 3. Redirect ke halaman detail lamaran yang baru dibuat
        return redirect()->route('candidate.applications.show', $newApplication)
                         ->with('status', 'Lamaran berhasil diajukan! Silakan unggah dokumen yang diperlukan untuk lamaran ini.');
    }
}
