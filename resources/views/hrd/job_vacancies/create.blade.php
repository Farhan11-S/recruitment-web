@extends('layouts.hrd')

@section('title', 'Tambah Lowongan Baru')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Tambah Lowongan Pekerjaan Baru</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('hrd.job_vacancies.store') }}" method="POST">
                @include('hrd.job_vacancies._form')
            </form>
        </div>
    </div>
</div>
@endsection
