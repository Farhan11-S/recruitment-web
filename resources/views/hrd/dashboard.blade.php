@extends('layouts.hrd')

@section('title', 'Dashboard')

@section('content')
  <div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Dashboard Utama</h1>
    </div>

    <div class="row">
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary h-100 py-2 shadow">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="fw-bold text-primary text-uppercase mb-1 text-xs">Lowongan Aktif</div>
                <div class="h5 fw-bold mb-0 text-gray-800">{{ $openVacanciesCount }}</div>
              </div>
              <div class="col-auto">
                <i class="bi bi-briefcase-fill fs-2 text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success h-100 py-2 shadow">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="fw-bold text-success text-uppercase mb-1 text-xs">Total Pelamar</div>
                <div class="h5 fw-bold mb-0 text-gray-800">{{ $totalApplicantsCount }}</div>
              </div>
              <div class="col-auto">
                <i class="bi bi-people-fill fs-2 text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info h-100 py-2 shadow">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="fw-bold text-info text-uppercase mb-1 text-xs">Pelamar Baru (Hari ini)</div>
                <div class="h5 fw-bold mb-0 text-gray-800">{{ $newApplicantsTodayCount }}</div>
              </div>
              <div class="col-auto">
                <i class="bi bi-person-plus-fill fs-2 text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-xl-7 col-lg-6">
        <div class="card mb-4 shadow">
          <div class="card-header py-3">
            <h6 class="fw-bold text-primary m-0">Pelamar yang Perlu Diproses</h6>
          </div>
          <div class="card-body">
            <div class="chart-area">
              <canvas id="applicantsByStatusChart"></canvas>
            </div>
          </div>
        </div>
      </div>

      <div class="col-xl-5 col-lg-6">
        <div class="card mb-4 shadow">
          <div class="card-header py-3">
            <h6 class="fw-bold text-primary m-0">Lowongan Paling Populer</h6>
          </div>
          <div class="card-body">
            @forelse($topVacancies as $vacancy)
              <div class="d-flex justify-content-between align-items-center border-bottom mb-2 pb-2">
                <span>{{ $vacancy->title }}</span>
                <span class="badge bg-primary rounded-pill">{{ $vacancy->applications_count }} Pelamar</span>
              </div>
            @empty
              <p class="text-muted text-center">Belum ada data lamaran.</p>
            @endforelse
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // Data dari controller
      const applicantsData = @json($applicantsByStatus);

      const labels = Object.keys(applicantsData).map(key => key.replace(/_/g, ' ').replace(/\b\w/g, l => l
        .toUpperCase()));
      const data = Object.values(applicantsData);

      // Pengaturan Grafik
      const ctx = document.getElementById('applicantsByStatusChart').getContext('2d');
      const myBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: labels,
          datasets: [{
            label: "Jumlah Pelamar",
            backgroundColor: "#4e73df",
            hoverBackgroundColor: "#2e59d9",
            borderColor: "#4e73df",
            data: data,
          }],
        },
        options: {
          maintainAspectRatio: false,
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                stepSize: 1
              }
            }
          },
          plugins: {
            legend: {
              display: false
            }
          }
        }
      });
    });
  </script>

  {{-- Tambahkan CSS untuk kartu ringkasan --}}
  <style>
    .card .border-left-primary {
      border-left: 0.25rem solid #4e73df !important;
    }

    .card .border-left-success {
      border-left: 0.25rem solid #1cc88a !important;
    }

    .card .border-left-info {
      border-left: 0.25rem solid #36b9cc !important;
    }

    .chart-area {
      position: relative;
      height: 20rem;
      width: 100%;
    }
  </style>
@endsection
