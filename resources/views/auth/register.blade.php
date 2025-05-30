<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Baru - Rekrutmen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Mengambil inspirasi dari kingev.id: bersih dan modern */
        body {
            background-color: #f8f9fa;
            /* Latar belakang abu-abu muda */
        }

        .register-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .register-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            width: 100%;
            max-width: 450px;
        }

        .register-card .card-header {
            background-color: #fff;
            border-bottom: none;
            text-align: center;
            padding: 2rem 1rem 0 1rem;
        }

        .register-card .card-title {
            font-weight: 700;
            color: #333;
        }

        .register-card .card-subtitle {
            color: #6c757d;
        }

        .form-control {
            border-radius: 8px;
            padding: 0.8rem 1rem;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }

        .btn-primary {
            background-color: #0d6efd;
            /* Warna biru seperti kingev.id */
            border-color: #0d6efd;
            border-radius: 8px;
            padding: 0.8rem;
            font-weight: 600;
        }
    </style>
</head>

<body>

    <div class="register-container">
        <div class="card register-card">
            <div class="card-header">
                <h3 class="card-title">Buat Akun Kandidat</h3>
                <p class="card-subtitle mb-4">Mulai karir Anda bersama kami.</p>
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

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Alamat Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">DAFTAR</button>
                    </div>

                </form>

                <div class="text-center mt-4">
                    <p class="text-muted">
                        Sudah punya akun? <a href="/">Masuk di sini</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

</body>

</html>