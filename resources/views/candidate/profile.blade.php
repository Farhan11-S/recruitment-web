@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="row">
    {{-- KOLOM KIRI: PROFIL PENGGUNA --}}
    <div class="col-md-4 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <i class="bi bi-person-circle fs-1 text-primary"></i>
                <h5 class="card-title mt-3">{{ $user->name }}</h5>
                <p class="text-muted mb-0">{{ $user->email }}</p>
                <hr>
                <div class="text-start">
                    <p class="mb-2">
                        <i class="bi bi-telephone me-2"></i>
                        {{ $user->application->phone_number ?? 'No. Telepon belum diisi' }}
                    </p>
                    <p class="mb-0">
                        <i class="bi bi-geo-alt me-2"></i>
                        {{ $user->application->address ?? 'Alamat belum diisi' }}
                    </p>
                </div>
                <div class="d-grid mt-4">
                    <a href="#" class="btn btn-outline-primary">Edit Profil & Data Diri</a>
                </div>
            </div>
        </div>
    </div>

    {{-- KOLOM KANAN: STATUS & DOKUMEN --}}
    <div class="col-md-8">
        {{-- KARTU STATUS LAMARAN --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 pt-3">
                <h5 class="mb-0">Status Lamaran Anda</h5>
            </div>
            <div class="card-body">
                @php
                $status = $user->application->status;
                $statusText = str_replace('_', ' ', $status);
                $badgeColor = 'secondary';
                if ($status === 'menunggu_seleksi') $badgeColor = 'primary';
                if ($status === 'tes_psikotes') $badgeColor = 'info text-dark';
                if ($status === 'diterima') $badgeColor = 'success';
                if ($status === 'ditolak') $badgeColor = 'danger';
                @endphp
                <h4>
                    <span class="badge bg-{{ $badgeColor }} text-capitalize">{{ $statusText }}</span>
                </h4>
                <p class="text-muted">Ini adalah status terbaru dari proses rekrutmen yang sedang Anda jalani.</p>

                {{-- =============================================== --}}
                {{-- LOGIKA KONDISIONAL UNTUK TOMBOL         --}}
                {{-- =============================================== --}}

                @if ($status === 'belum_lengkap')
                <div class="alert alert-warning">
                    Profil atau data diri Anda belum lengkap. Silakan lengkapi data diri dan unggah dokumen yang dibutuhkan.
                </div>
                <a href="#" class="btn btn-primary"><i class="bi bi-upload me-2"></i> Upload Dokumen</a>

                @elseif ($status === 'tes_psikotes')
                <div class="alert alert-info">
                    Selamat! Anda telah memasuki tahap Uji Psikotes. Silakan klik tombol di bawah untuk memulai tes.
                </div>
                <a href="#" class="btn btn-success fw-bold"><i class="bi bi-pencil-square me-2"></i> Mulai Uji Psikotes</a>

                @endif

            </div>
        </div>

        {{-- KARTU DOKUMEN TERUNGGAH --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-3">
                <h5 class="mb-0">Dokumen Terunggah</h5>
            </div>
            <div class="card-body">
                @if ($user->application->documents->isNotEmpty())
                <ul class="list-group list-group-flush">
                    @foreach ($user->application->documents as $document)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <i class="bi bi-file-earmark-text text-primary me-2"></i>
                            {{ $document->document_name }}
                        </div>
                        <small class="text-muted">Diunggah pada: {{ $document->created_at->format('d M Y') }}</small>
                    </li>
                    @endforeach
                </ul>
                @else
                <p class="text-muted text-center">Belum ada dokumen yang diunggah.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
