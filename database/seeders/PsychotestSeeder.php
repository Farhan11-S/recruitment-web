<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use App\Models\PsychotestQuestion;

class PsychotestSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan file JSON ada
        if (!Storage::disk('public')->exists('psychotest/questions.json')) {
            $this->command->error('File questions.json tidak ditemukan!');
            return;
        }

        $jsonContent = Storage::disk('public')->get('psychotest/questions.json');
        $questionsData = json_decode($jsonContent);

        foreach ($questionsData as $qData) {
            // Buat pertanyaan utama
            $question = PsychotestQuestion::create([
                'question_text' => $qData->question
            ]);

            // Buat pilihan jawabannya
            foreach ($qData->options as $key => $optionText) {
                $question->options()->create([
                    'option_text' => $optionText,
                    'is_correct' => ($key === $qData->correct_answer)
                ]);
            }
        }
    }
}
