@extends('layouts.app')

@section('title', 'Daftar Lowongan Pekerjaan')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="text-center mb-5">
                <h1 class="display-5 fw-bold">Temukan Karir Impian Anda</h1>
                <p class="lead text-muted">Jelajahi berbagai kesempatan karir yang tersedia dan bergabunglah bersama kami.</p>
            </div>

            @forelse ($vacancies as $vacancy)
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-9">
                            <h4 class="card-title">{{ $vacancy->title }}</h4>
                            <p class="card-text text-muted">
                                {{ \Illuminate\Support\Str::limit($vacancy->description, 200) }}
                            </p>
                        </div>
                        <div class="col-md-3 text-md-end">
                            @if ($vacancy->deadline_at)
                            <p class="mb-2">
                                <small class="text-danger">
                                    <i class="bi bi-calendar-x"></i> Batas Lamaran:
                                    <br>
                                    <strong>{{ \Carbon\Carbon::parse($vacancy->deadline_at)->isoFormat('D MMMM YYYY') }}</strong>
                                </small>
                            </p>
                            @endif
                            <a href="{{ route('job_vacancies.show', $vacancy) }}" class="btn btn-primary mt-2">Lihat Detail & Lamar</a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="card text-center py-5">
                <div class="card-body">
                    <h4 class="card-title">Tidak Ada Lowongan</h4>
                    <p class="text-muted">Saat ini belum ada lowongan pekerjaan yang tersedia. Silakan periksa kembali nanti.</p>
                </div>
            </div>
            @endforelse

            {{-- Link Paginasi --}}
            <div class="d-flex justify-content-center mt-4">
                {{ $vacancies->links() }}
            </div>

        </div>
    </div>
</div>
@endsection