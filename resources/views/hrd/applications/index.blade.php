@extends('layouts.hrd')

@section('title', 'Daftar Pelamar')

@section('content')
  <div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Daftar Pelamar</h1>

    {{-- Notifikasi Sukses --}}
    @if (session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- FORM FILTER --}}
    <div class="card mb-4 shadow-sm">
      <div class="card-body">
        <form
          method="GET"
          action="{{ route('hrd.applications.index') }}"
          class="row g-3 align-items-center"
        >
          <div class="col-md-5">
            <label
              for="job_vacancy_id"
              class="form-label"
            >Filter Lowongan</label>
            <select
              id="job_vacancy_id"
              name="job_vacancy_id"
              class="form-select"
            >
              <option value="">Semua Lowongan</option>
              @foreach ($vacanciesForFilter as $vacancy)
                <option
                  value="{{ $vacancy->id }}"
                  {{ $request->job_vacancy_id == $vacancy->id ? 'selected' : '' }}
                >
                  {{ $vacancy->title }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="col-md-5">
            <label
              for="status"
              class="form-label"
            >Filter Status Lamaran</label>
            <select
              id="status"
              name="status"
              class="form-select"
            >
              <option value="">Semua Status</option>
              @foreach ($statusesForFilter as $status)
                <option
                  value="{{ $status }}"
                  {{ $request->status == $status ? 'selected' : '' }}
                  class="text-capitalize"
                >
                  {{ str_replace('_', ' ', $status) }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="col-md-2 d-flex align-items-end">
            <button
              type="submit"
              class="btn btn-primary w-100 me-2"
            >Filter</button>
            <a
              href="{{ route('hrd.applications.index') }}"
              class="btn btn-secondary w-100"
            >Reset</a>
          </div>
        </form>
      </div>
    </div>

    {{-- TABEL DAFTAR PELAMAR --}}
    <div class="card shadow-sm">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table-striped table-hover table">
            <thead class="table-dark">
              <tr>
                <th>Nama Pelamar</th>
                <th>Lowongan Dilamar</th>
                <th>Status Saat Ini</th>
                <th>Skor Psikotes</th>
                <th>Tgl Lamar</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($applications as $application)
                <tr>
                  <td>{{ $application->user->name }}</td>
                  <td>{{ $application->jobVacancy->title }}</td>
                  <td>
                    @php
                      $status = $application->status;
                      $statusText = str_replace('_', ' ', $status);
                      $badgeColor = 'secondary';
                      if (in_array($status, ['menunggu_seleksi', 'tes_psikotes'])) {
                          $badgeColor = 'primary';
                      }
                      if (in_array($status, ['wawancara_pertama', 'wawancara_kedua'])) {
                          $badgeColor = 'info text-dark';
                      }
                      if ($status === 'diterima') {
                          $badgeColor = 'success';
                      }
                      if ($status === 'ditolak') {
                          $badgeColor = 'danger';
                      }
                    @endphp
                    <span class="badge bg-{{ $badgeColor }} text-capitalize">{{ $statusText }}</span>
                    @if ($application->status === 'tes_psikotes')
                      @if ($application->testResult)
                        <small class="d-block text-muted">(Menunggu Review)</small>
                      @else
                        <small class="d-block text-muted">(Menunggu Pengerjaan)</small>
                      @endif
                    @endif
                  </td>
                  <td>
                    {{-- BARU: Tampilkan skor jika ada --}}
                    @if ($application->testResult)
                      <strong class="text-primary">{{ $application->testResult->score }} / 100</strong>
                    @else
                      -
                    @endif
                  </td>
                  <td>{{ $application->created_at->isoFormat('D MMM YYYY') }}</td>
                  <td class="text-center">
                    {{-- Tombol aksi hanya muncul di status tertentu --}}
                    @if (in_array($application->status, ['menunggu_seleksi', 'tes_psikotes', 'wawancara_pertama', 'wawancara_kedua']))
                      <div
                        class="btn-group"
                        role="group"
                      >
                        {{-- Form untuk ACCEPT --}}
                        <form
                          action="{{ route('hrd.applications.updateStatus', $application) }}"
                          method="POST"
                          class="d-inline"
                        >
                          @csrf
                          @method('PATCH')
                          <input
                            type="hidden"
                            name="action"
                            value="accept"
                          >
                          <button
                            type="submit"
                            class="btn btn-sm btn-success"
                            title="Lolos ke tahap selanjutnya"
                          ><i class="bi bi-check-circle"></i> Accept</button>
                        </form>
                        {{-- Form untuk REJECT --}}
                        <form
                          action="{{ route('hrd.applications.updateStatus', $application) }}"
                          method="POST"
                          class="d-inline"
                          onsubmit="return confirm('Apakah Anda yakin ingin menolak kandidat ini?');"
                        >
                          @csrf
                          @method('PATCH')
                          <input
                            type="hidden"
                            name="action"
                            value="reject"
                          >
                          <button
                            type="submit"
                            class="btn btn-sm btn-danger"
                            title="Tolak kandidat"
                          ><i class="bi bi-x-circle"></i> Reject</button>
                        </form>
                      </div>
                    @else
                      -
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td
                    colspan="5"
                    class="py-4 text-center"
                  >Data pelamar tidak ditemukan.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div class="d-flex justify-content-end mt-3">
          {{ $applications->links() }}
        </div>
      </div>
    </div>
  </div>
@endsection
