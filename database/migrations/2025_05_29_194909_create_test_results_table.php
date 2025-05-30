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
        Schema::create('test_results', function (Blueprint $table) {
            $table->id();

            // Relasi one-to-one dengan applications
            // unique() memastikan satu aplikasi hanya bisa punya satu hasil tes.
            $table->foreignId('application_id')->unique()->constrained('applications')->onDelete('cascade');

            $table->string('token')->unique(); // Token untuk link di email
            $table->float('score')->nullable(); // Skor baru diisi setelah tes selesai
            $table->dateTime('completed_at')->nullable(); // Waktu tes selesai
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_results');
    }
};
