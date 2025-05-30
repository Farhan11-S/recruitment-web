<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CandidateController extends Controller
{
    /**
     * Menampilkan halaman profil kandidat yang sedang login.
     *
     * @return \Illuminate\View\View
     */
    public function profile()
    {
        // Ambil user yang sedang login, beserta relasi application dan documents
        // Eager loading ini lebih efisien karena menghindari N+1 problem
        $user = Auth::user()->load(['application', 'application.documents']);

        // Kirim data user ke view
        return view('candidate.profile', compact('user'));
    }
}
