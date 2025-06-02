<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard HRD') - Portal Rekrutmen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            background-color: #f4f7f9;
        }

        #sidebar {
            width: 250px;
            min-height: 100vh;
            background-color: #343a40;
            color: #fff;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            z-index: 100;
        }

        #sidebar .nav-link {
            color: #adb5bd;
            padding: 0.75rem 1.5rem;
            display: flex;
            align-items: center;
        }

        #sidebar .nav-link:hover {
            background-color: #495057;
            color: #fff;
        }

        #sidebar .nav-link.active {
            background-color: #0d6efd;
            color: #fff;
        }

        #sidebar .nav-link .bi {
            margin-right: 0.75rem;
        }

        .main-content {
            margin-left: 250px;
            width: calc(100% - 250px);
            padding: 2rem;
        }

        .navbar-logout {
            width: calc(100% - 250px);
            left: 250px;
            z-index: 99;
        }

        .card {
            border: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }
    </style>
</head>

<body>

    <nav id="sidebar" class="d-flex flex-column p-0">
        <div class="p-4">
            <h4 class="fw-bold">HRD Dashboard</h4>
        </div>
        <ul class="nav flex-column flex-grow-1">
            <li class="nav-item">
                {{-- Cek apakah route saat ini adalah 'hrd.dashboard' --}}
                <a class="nav-link {{ request()->routeIs('hrd.dashboard') ? 'active' : '' }}" href="#">
                    <i class="bi bi-grid-1x2-fill"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                {{-- Cek apakah nama route saat ini dimulai dengan 'hrd.job_vacancies' --}}
                <a class="nav-link {{ request()->routeIs('hrd.job_vacancies.*') ? 'active' : '' }}" href="{{ route('hrd.job_vacancies.index') }}">
                    <i class="bi bi-briefcase-fill"></i> Manajemen Lowongan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('hrd.applications.*') ? 'active' : '' }}" href="#">
                    <i class="bi bi-people-fill"></i> Daftar Pelamar
                </a>
            </li>
        </ul>
        <div class="p-4 mt-auto">
            <small>{{ Auth::user()->name }}</small><br>
            <a class="text-white-50" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout <i class="bi bi-box-arrow-right"></i>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </nav>

    <div class="main-content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
