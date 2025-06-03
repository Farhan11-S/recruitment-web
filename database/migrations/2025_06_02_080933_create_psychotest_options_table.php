<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('psychotest_options', function (Blueprint $table) {
            $table->id();
            // onDelete('cascade') akan menghapus semua opsi jika pertanyaannya dihapus
            $table->foreignId('psychotest_question_id')->constrained('psychotest_questions')->onDelete('cascade');
            $table->string('option_text');
            $table->boolean('is_correct')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('psychotest_options');
    }
};
