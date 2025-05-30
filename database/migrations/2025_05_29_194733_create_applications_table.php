<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel users
            // onDelete('cascade') berarti jika user dihapus, aplikasinya juga ikut terhapus.
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->string('phone_number')->nullable();
            $table->text('address')->nullable();
            
            // Status rekrutmen dengan nilai default
            $table->enum('status', [
                'belum_lengkap', 
                'menunggu_seleksi', 
                'tes_psikotes', 
                'ditolak', 
                'diterima'
            ])->default('belum_lengkap');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
