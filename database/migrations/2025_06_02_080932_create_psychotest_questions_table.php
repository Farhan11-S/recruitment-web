<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('psychotest_questions', function (Blueprint $table) {
            $table->id();
            $table->text('question_text');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('psychotest_questions');
    }
};
