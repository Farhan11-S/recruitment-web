<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Menampilkan halaman form registrasi.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Menangani permintaan registrasi.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        // 1. Validasi Input
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // 2. Buat User Baru dengan Role 'candidate'
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'candidate', // Role ditetapkan secara otomatis
        ]);

        // 3. Buat data aplikasi yang terhubung dengan user baru
        // Status awal adalah 'belum_lengkap'
        if ($user) {
            Application::create([
                'user_id' => $user->id,
                'status' => 'belum_lengkap'
            ]);
        }

        // 4. Login user secara otomatis
        Auth::login($user);

        // 5. Redirect ke halaman profil kandidat setelah berhasil
        // Ganti 'candidate.profile' dengan nama route dashboard Anda
        return redirect()->route('candidate.profile')->with('status', 'Pendaftaran berhasil! Selamat datang.');
    }
}
