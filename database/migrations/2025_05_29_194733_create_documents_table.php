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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel applications
            $table->foreignId('application_id')->constrained('applications')->onDelete('cascade');
            
            $table->string('document_name'); // e.g., 'CV', 'KTP'
            $table->string('file_path'); // path penyimpanan file
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
