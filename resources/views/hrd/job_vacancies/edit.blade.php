@extends('layouts.hrd')

@section('title', 'Edit Lowongan Pekerjaan')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit Lowongan: {{ $vacancy->title }}</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('hrd.job_vacancies.update', $vacancy) }}" method="POST">
                @method('PUT')
                @include('hrd.job_vacancies._form', ['vacancy' => $vacancy])
            </form>
        </div>
    </div>
</div>
@endsection
