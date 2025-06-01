<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CandidateController extends Controller
{
    /**
     * Menampilkan halaman profil kandidat yang sedang login.
     *
     * @return \Illuminate\View\View
     */
    public function profile()
    {
        $user = Auth::user();

        if (!$user->candidateProfile) {
            $user->candidateProfile()->create(['is_complete' => false]);
            $user->load('candidateProfile');
        } else {
            $user->load('candidateProfile');
        }

        $user->load('applications.jobVacancy');

        return view('candidate.profile', compact('user'));
    }
}