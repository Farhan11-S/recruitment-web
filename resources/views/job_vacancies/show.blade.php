@extends('layouts.app')

@section('title', $jobVacancy->title)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="mb-4">
                <a href="{{ route('job_vacancies.index') }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Kembali ke Daftar Lowongan</a>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-white p-4">
                    <h1 class="h2 fw-bold mb-1">{{ $jobVacancy->title }}</h1>
                    @if ($jobVacancy->deadline_at)
                    <p class="text-danger mb-0">
                        <i class="bi bi-calendar-x"></i> Batas Lamaran: <strong>{{ \Carbon\Carbon::parse($jobVacancy->deadline_at)->isoFormat('D MMMM YYYY') }}</strong>
                    </p>
                    @endif
                </div>
                <div class="card-body p-4">
                    <h5 class="fw-bold">Deskripsi Pekerjaan & Kualifikasi</h5>
                    <div class="fs-6" style="white-space: pre-wrap;">{{ $jobVacancy->description }}</div>

                    <hr class="my-4">

                    {{-- BAGIAN TOMBOL AKSI (LOGIKA UTAMA) --}}
                    <div class="text-center">
                        @guest
                        {{-- Jika user adalah tamu (belum login) --}}
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Login untuk Melamar</a>
                        @endguest

                        @auth
                        {{-- Jika user sudah login --}}
                        @if (Auth::user()->role === 'candidate')
                        @if ($hasApplied)
                        {{-- Jika kandidat sudah pernah melamar --}}
                        <div class="alert alert-success d-inline-block">
                            <i class="bi bi-check-circle-fill"></i> Anda sudah melamar untuk posisi ini.
                            <br>
                            <a href="{{ route('candidate.profile') }}">Lihat status lamaran di profil Anda.</a>
                        </div>
                        @else
                        {{-- Jika kandidat belum melamar, tampilkan tombol --}}
                        <form action="{{ route('job_vacancies.apply', $jobVacancy) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-lg">Lamar Sekarang</button>
                        </form>
                        @endif
                        @else
                        {{-- Jika user login sebagai HRD atau Manager --}}
                        <p class="text-muted">Anda login sebagai {{ Auth::user()->role }}. Hanya kandidat yang dapat melamar.</p>
                        @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
