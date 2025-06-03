<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Application;
use App\Models\TestResult;

class PsychotestController extends Controller
{
    /**
     * Menampilkan halaman tes psikotes.
     */
    public function show(Application $application)
    {
        // Otorisasi: Pastikan kandidat hanya bisa mengakses tes untuk lamarannya sendiri
        if (Auth::id() !== $application->user_id) {
            abort(403);
        }

        // Cek apakah status lamaran sudah benar dan tes belum pernah diambil
        if ($application->status !== 'tes_psikotes' || $application->testResult) {
            return redirect()->route('candidate.profile')->with('error', 'Anda tidak dapat mengakses halaman ini.');
        }

        $questions = PsychotestQuestion::with('options')->inRandomOrder()->take(10)->get();

        return view('psychotest.show', compact('questions', 'application'));
    }

    /**
     * Menyimpan hasil tes psikotes.
     */
    public function store(Request $request, Application $application)
    {
        // Otorisasi & Validasi (sama seperti di method show)
        if (Auth::id() !== $application->user_id || $application->status !== 'tes_psikotes' || $application->testResult) {
            abort(403);
        }

        $userAnswers = $request->input('answers', []);
        $questionIds = array_keys($userAnswers);

        $correctOptions = PsychotestOption::whereIn('psychotest_question_id', $questionIds)
            ->where('is_correct', true)
            ->pluck('id', 'psychotest_question_id');

        $score = 0;
        foreach ($userAnswers as $questionId => $chosenOptionId) {
            if (isset($correctOptions[$questionId]) && $correctOptions[$questionId] == $chosenOptionId) {
                $score += 10;
            }
        }

        // Simpan hasil tes
        TestResult::create([
            'application_id' => $application->id,
            'score' => $score,
            'token' => bin2hex(random_bytes(16)),
            'answers' => json_encode($userAnswers), // Simpan jawaban user
            'completed_at' => now(),
            // 'token' bisa di-generate jika diperlukan
        ]);

        // uncomment jika ingin mengupdate status lamaran berdasarkan skor
        // $nextStatus = ($score >= 70) ? 'wawancara_pertama' : 'ditolak'; // Contoh passing grade 70
        // $application->update(['status' => $nextStatus]);

        return redirect()->route('candidate.applications.show', $application)->with('status', 'Tes psikotes telah selesai. Terima kasih!');
    }
}
