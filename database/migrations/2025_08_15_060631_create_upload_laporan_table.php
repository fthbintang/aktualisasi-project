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
        Schema::create('upload_laporan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laporan_tahun_id')->constrained('laporan_tahun')->onDelete('cascade');
            $table->unsignedTinyInteger('bulan');
            $table->string('laporan_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('upload_laporan');
    }
};