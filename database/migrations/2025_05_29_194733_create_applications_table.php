<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel users
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // BARU: Relasi ke tabel jobs
            $table->foreignId('job_id')->constrained('jobs')->onDelete('cascade');
            $table->enum('status', [
                'belum_lengkap',
                'menunggu_seleksi',
                'tes_psikotes',
                'wawancara_pertama',
                'wawancara_kedua',
                'ditolak',
                'diterima'
            ])->default('belum_lengkap');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};