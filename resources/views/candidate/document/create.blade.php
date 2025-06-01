@extends('layouts.app')

@section('title', 'Upload Dokumen Lamaran')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-3">
                <h4 class="mb-0">Formulir Unggah Dokumen</h4>
                <p class="text-muted">Lengkapi semua dokumen yang dibutuhkan. Anda dapat mengganti file dengan
                    mengunggahnya kembali.</p>
            </div>
            <div class="card-body">
                {{-- Form harus memiliki enctype untuk upload file --}}
                <form method="POST" action="{{ route('candidate.documents.store') }}" enctype="multipart/form-data">
                    @csrf

                    @php
                    // Buat array asosiatif dari dokumen yang sudah diunggah untuk pengecekan mudah
                    $uploaded = $user->application->documents->pluck('file_path', 'document_name');
                    @endphp

                    {{-- Surat Lamaran --}}
                    <div class="mb-3">
                        <label for="surat_lamaran" class="form-label">Surat Lamaran <span
                                class="text-danger">*</span></label>
                        <input class="form-control @error('surat_lamaran') is-invalid @enderror" type="file"
                            id="surat_lamaran" name="surat_lamaran">
                        @if(isset($uploaded['Surat Lamaran']))
                        <small class="text-success d-block mt-1">Sudah terunggah. <a
                                href="{{ asset('storage/' . $uploaded['Surat Lamaran']) }}" target="_blank">Lihat
                                file</a></small>
                        @endif
                        @error('surat_lamaran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- CV --}}
                    <div class="mb-3">
                        <label for="cv" class="form-label">Curriculum Vitae (CV) <span
                                class="text-danger">*</span></label>
                        <input class="form-control @error('cv') is-invalid @enderror" type="file" id="cv" name="cv">
                        @if(isset($uploaded['CV']))
                        <small class="text-success d-block mt-1">Sudah terunggah. <a
                                href="{{ asset('storage/' . $uploaded['CV']) }}" target="_blank">Lihat file</a></small>
                        @endif
                        @error('cv') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- KTP & KK --}}
                    <div class="mb-3">
                        <label for="ktp_kk" class="form-label">Fotokopi KTP dan KK <span
                                class="text-danger">*</span></label>
                        <input class="form-control @error('ktp_kk') is-invalid @enderror" type="file" id="ktp_kk"
                            name="ktp_kk">
                        @if(isset($uploaded['Fotokopi KTP dan KK']))
                        <small class="text-success d-block mt-1">Sudah terunggah. <a
                                href="{{ asset('storage/' . $uploaded['Fotokopi KTP dan KK']) }}" target="_blank">Lihat
                                file</a></small>
                        @endif
                        @error('ktp_kk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Ijazah & Transkrip --}}
                    <div class="mb-3">
                        <label for="ijazah_transkrip" class="form-label">Fotokopi Ijazah dan Transkrip Nilai <span
                                class="text-danger">*</span></label>
                        <input class="form-control @error('ijazah_transkrip') is-invalid @enderror" type="file"
                            id="ijazah_transkrip" name="ijazah_transkrip">
                        @if(isset($uploaded['Fotokopi Ijazah dan Transkrip Nilai']))
                        <small class="text-success d-block mt-1">Sudah terunggah. <a
                                href="{{ asset('storage/' . $uploaded['Fotokopi Ijazah dan Transkrip Nilai']) }}"
                                target="_blank">Lihat file</a></small>
                        @endif
                        @error('ijazah_transkrip') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- SKCK (Optional) --}}
                    <div class="mb-3">
                        <label for="skck" class="form-label">Fotokopi SKCK (Opsional)</label>
                        <input class="form-control @error('skck') is-invalid @enderror" type="file" id="skck"
                            name="skck">
                        @if(isset($uploaded['Fotokopi SKCK']))
                        <small class="text-success d-block mt-1">Sudah terunggah. <a
                                href="{{ asset('storage/' . $uploaded['Fotokopi SKCK']) }}" target="_blank">Lihat
                                file</a></small>
                        @endif
                        @error('skck') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Dokumen Pendukung (Optional, Multiple) --}}
                    <div class="mb-4">
                        <label for="dokumen_pendukung" class="form-label">Dokumen Pendukung (Opsional, bisa lebih dari
                            satu)</label>
                        <input class="form-control @error('dokumen_pendukung.*') is-invalid @enderror" type="file"
                            id="dokumen_pendukung" name="dokumen_pendukung[]" multiple>
                        <small class="form-text text-muted">Contoh: Surat pengalaman kerja, sertifikat, dll.</small>
                        @error('dokumen_pendukung.*') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <hr>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Simpan dan Kirim Lamaran</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection