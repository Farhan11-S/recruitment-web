<!DOCTYPE html>
<html lang="id">

  <head>
    <meta charset="UTF-8">
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0"
    >
    <title>Login - Rekrutmen</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    >
    {{-- [UBAH] Seluruh blok style diganti dengan tema hijau --}}
    <style>
      :root {
        --primary-green: #006400;
        --primary-green-darker: #004d00;
      }

      body {
        background-color: #f8f9fa;
      }

      .login-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .login-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        width: 100%;
        max-width: 450px;
      }

      .login-card .card-header {
        background-color: #fff;
        border-bottom: none;
        text-align: center;
        padding: 2rem 1rem 0 1rem;
      }

      .login-card .card-title {
        font-weight: 700;
        color: var(--primary-green);
        /* Teks judul diubah menjadi hijau */
      }

      .login-card .card-subtitle {
        color: #6c757d;
      }

      .form-control:focus,
      .form-select:focus {
        border-color: #008000;
        box-shadow: 0 0 0 0.25rem rgba(0, 100, 0, 0.25);
      }

      .form-check-input:checked {
        background-color: var(--primary-green);
        border-color: var(--primary-green);
      }

      .btn-primary {
        background-color: var(--primary-green);
        border-color: var(--primary-green);
        border-radius: 8px;
        padding: 0.8rem;
        font-weight: 600;
      }

      .btn-primary:hover {
        background-color: var(--primary-green-darker);
        border-color: var(--primary-green-darker);
      }
    </style>
  </head>

  <body>

    <div class="login-container">
      <div class="card login-card">
        <div class="card-header">
          <h3 class="card-title">Selamat Datang Kembali</h3>
          <p class="card-subtitle mb-4">Silakan masuk ke akun Anda.</p>
        </div>
        <div class="card-body p-4">
          <form
            method="POST"
            action="{{ route('login') }}"
          >
            @csrf
            <div class="mb-3">
              <label
                for="email"
                class="form-label"
              >Alamat Email</label>
              <input
                id="email"
                type="email"
                class="form-control @error('email') is-invalid @enderror"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
              >
              @error('email')
                <span
                  class="invalid-feedback"
                  role="alert"
                ><strong>{{ $message }}</strong></span>
              @enderror
            </div>
            <div class="mb-3">
              <label
                for="password"
                class="form-label"
              >Password</label>
              <input
                id="password"
                type="password"
                class="form-control"
                name="password"
                required
              >
            </div>
            <div class="d-flex justify-content-between align-items-center mb-4">
              <div class="form-check">
                <input
                  id="remember"
                  class="form-check-input"
                  type="checkbox"
                  name="remember"
                  {{ old('remember') ? 'checked' : '' }}
                >
                <label
                  class="form-check-label"
                  for="remember"
                >Ingat Saya</label>
              </div>
            </div>
            <div class="d-grid">
              <button
                type="submit"
                class="btn btn-primary"
              >MASUK</button>
            </div>
          </form>
          <div class="mt-4 text-center">
            <p class="text-muted">Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a></p>
          </div>
        </div>
      </div>
    </div>

  </body>

</html>
