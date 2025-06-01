<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CandidateProfile;

class CandidateProfileController extends Controller
{
    /**
     * Menampilkan form untuk mengedit profil kandidat.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        // Ambil data user yang sedang login beserta profilnya
        $user = Auth::user()->load('candidateProfile');

        return view('candidate.profile.edit', compact('user'));
    }

    /**
     * Memperbarui profil kandidat di database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        // 1. Validasi semua input yang diperlukan
        $validatedData = $request->validate([
            'place_of_birth' => 'required|string|max:100',
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required|in:laki-laki,perempuan',
            'phone_number' => 'required|string|min:10|max:15',
            'address' => 'required|string|min:20',
        ]);

        // 2. Dapatkan profil kandidat yang sedang login
        $profile = Auth::user()->candidateProfile;

        // 3. Tambahkan status 'is_complete' ke data yang akan diupdate
        // Karena semua field sudah divalidasi 'required', maka profil dianggap lengkap.
        $validatedData['is_complete'] = true;

        // 4. Update data profil
        $profile->update($validatedData);

        // 5. Redirect kembali ke halaman profil utama dengan pesan sukses
        return redirect()->route('candidate.profile')->with('status', 'Profil Anda telah berhasil diperbarui dan dilengkapi!');
    }
}