<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles   // Parameter ini akan menangkap semua role yang dikirim (e.g., 'hrd', 'candidate')
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect('login');
        }

        // 2. Ambil data user yang sedang login
        $user = Auth::user();

        // 3. Cek apakah role user ada di dalam daftar role yang diizinkan ($roles)
        foreach ($roles as $role) {
            if ($user->role === $role) {
                // Jika cocok, lanjutkan request ke tujuan berikutnya
                return $next($request);
            }
        }
        
        // 4. Jika role tidak cocok, hentikan request dan tampilkan halaman error 403 (Forbidden)
        abort(403, 'AKSI TIDAK DIIZINKAN.');
    }
}
