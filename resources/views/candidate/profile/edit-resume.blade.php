@extends('layouts.app')

@section('title', 'Upload CV Utama')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-3">
                <h4 class="mb-0">Formulir Upload CV Utama</h4>
                <p class="text-muted">CV ini akan menjadi CV utama yang dilihat oleh HRD.</p>
            </div>
            <div class="card-body p-4">

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- Form harus memiliki enctype untuk upload file --}}
                <form method="POST" action="{{ route('candidate.resume.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH') {{-- Menggunakan PATCH karena hanya update sebagian data profil --}}

                    <div class="mb-3">
                        <label for="resume" class="form-label">Pilih File CV <span class="text-danger">*</span></label>
                        <input class="form-control" type="file" id="resume" name="resume" required>
                        <small class="form-text text-muted">
                            Format yang diizinkan: PDF, DOC, DOCX. Maksimal ukuran: 2MB.
                        </small>
                    </div>

                    @php
                    $currentResume = Auth::user()->candidateProfile?->resume_path;
                    @endphp

                    @if($currentResume)
                    <div class="alert alert-info">
                        Anda sudah memiliki CV yang terunggah. Mengunggah file baru akan menggantikan file yang lama.
                        <a href="{{ asset('storage/' . $currentResume) }}" target="_blank">Lihat CV saat ini</a>.
                    </div>
                    @endif

                    <hr>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('candidate.profile') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Upload dan Simpan CV</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
