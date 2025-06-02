@extends('layouts.app')

@section('title', 'Profil Saya - ' . $user->name)

@section('content')
<div class="row">
    {{-- KOLOM KIRI: INFORMASI PROFIL PENGGUNA --}}
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-person-circle fs-1 text-primary"></i>
                <h5 class="card-title mt-3">{{ $user->name }}</h5>
                <p class="text-muted mb-2">{{ $user->email }}</p>

                @if(session('status'))
                <div class="alert alert-success mt-2">
                    {{ session('status') }}
                </div>
                @endif
            </div>
            <div class="list-group list-group-flush">
                <div class="list-group-item">
                    <small class="text-muted">Tempat, Tanggal Lahir</small>
                    <p class="mb-0">
                        {{ $user->candidateProfile?->place_of_birth ?? '-' }},
                        {{ $user->candidateProfile?->date_of_birth ? \Carbon\Carbon::parse($user->candidateProfile->date_of_birth)->isoFormat('D MMMM YYYY') : '-' }}
                    </p>
                </div>
                <div class="list-group-item">
                    <small class="text-muted">Jenis Kelamin</small>
                    <p class="mb-0 text-capitalize">{{ $user->candidateProfile?->gender ?? '-' }}</p>
                </div>
                <div class="list-group-item">
                    <small class="text-muted">No. Telepon</small>
                    <p class="mb-0">{{ $user->candidateProfile?->phone_number ?? '-' }}</p>
                </div>
                <div class="list-group-item">
                    <small class="text-muted">Alamat</small>
                    <p class="mb-0" style="white-space: pre-wrap;">{{ $user->candidateProfile?->address ?? '-' }}</p>
                </div>
                <div class="list-group-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">CV Utama</small>
                            @if($user->candidateProfile?->resume_path)
                            <p class="mb-0"><a href="{{ asset('storage/' . $user->candidateProfile->resume_path) }}" target="_blank">Lihat CV Terunggah <i class="bi bi-box-arrow-up-right"></i></a></p>
                            @else
                            <p class="mb-0 text-danger">Belum diunggah</p>
                            @endif
                        </div>
                        <div>
                            {{-- Tombol ini mengarah ke halaman edit CV --}}
                            <a href="{{ route('candidate.resume.edit') }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil-square"></i>
                                {{ $user->candidateProfile?->resume_path ? 'Ubah' : 'Upload' }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- KOLOM KANAN: KELENGKAPAN PROFIL & RIWAYAT LAMARAN --}}
    <div class="col-lg-8">
        {{-- KARTU KELENGKAPAN PROFIL & AKSI --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 pt-3">
                <h5 class="mb-0">Status Profil & Tindakan</h5>
            </div>
            <div class="card-body">
                @if (!$user->candidateProfile?->is_complete || !$user->candidateProfile?->resume_path)
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    Profil Anda belum sepenuhnya lengkap atau CV utama belum diunggah. Silakan lengkapi untuk dapat
                    melamar pekerjaan.
                </div>
                @else
                <div class="alert alert-success">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    Profil Anda sudah lengkap dan CV utama telah terunggah! Anda siap melamar pekerjaan.
                </div>
                @endif

                <div class="d-flex flex-wrap gap-2">
                    @if (!$user->candidateProfile?->is_complete)
                    <a href="{{ route('candidate.profile.edit') }}" class="btn btn-primary"><i
                            class="bi bi-pencil-square me-1"></i> Lengkapi Data Diri</a>
                    @endif

                    @if (!$user->candidateProfile?->resume_path)
                    <a href="{{ route('candidate.resume.edit') }}" class="btn btn-info text-white"><i class="bi bi-file-earmark-arrow-up-fill me-1"></i> Upload CV Utama</a>
                    @endif
                </div>
            </div>
        </div>

        {{-- KARTU RIWAYAT LAMARAN --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-3">
                <h5 class="mb-0">Riwayat Lamaran Saya</h5>
            </div>
            <div class="card-body">
                @if ($user->applications->isNotEmpty())
                <div class="list-group list-group-flush">
                    @foreach ($user->applications as $application)
                    <div class="list-group-item px-0">
                        <div class="d-flex w-100 justify-content-between">
                            <h6 class="mb-1">{{ $application->jobVacancy?->title ?? 'Lowongan tidak ditemukan' }}</h6>
                            <small class="text-muted">{{ $application->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="mb-1">
                            @php
                            $status = $application->status;
                            $statusText = str_replace('_', ' ', $status);
                            $badgeColor = 'secondary'; // default
                            if (in_array($status, ['menunggu_seleksi', 'tes_psikotes'])) $badgeColor = 'primary';
                            if (in_array($status, ['wawancara_pertama', 'wawancara_kedua'])) $badgeColor = 'info
                            text-dark';
                            if ($status === 'diterima') $badgeColor = 'success';
                            if ($status === 'ditolak') $badgeColor = 'danger';
                            if ($status === 'belum_lengkap') $badgeColor = 'warning text-dark';
                            @endphp
                            Status: <span class="badge bg-{{ $badgeColor }} text-capitalize">{{ $statusText }}</span>
                        </p>
                        <a href="{{ route('candidate.applications.show', $application) }}" class="btn btn-sm btn-outline-primary mt-2">Lihat Detail Lamaran</a>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-muted text-center">Anda belum pernah melamar pekerjaan apapun.</p>
                <div class="text-center">
                    <a href="{{ route('job_vacancies.index') }}" class="btn btn-success">Lihat Lowongan Tersedia</a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection