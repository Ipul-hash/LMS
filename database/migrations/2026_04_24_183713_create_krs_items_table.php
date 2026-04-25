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
        Schema::create('krs_items', function (Blueprint $table) {
            $table->id();

            // 1. Relasi ke tabel krs (Induk)
            // Harus BigInt Unsigned biar cocok sama krs.id
            $table->foreignId('krs_id')
                  ->constrained('krs')
                  ->onDelete('cascade');

            // 2. Relasi ke tabel classes (Katalog Kelas)
            // Harus BigInt Unsigned biar cocok sama classes.id
            $table->foreignId('kelas_id')
                  ->constrained('classes')
                  ->onDelete('restrict');

            // 3. Poin SKS (disimpan per baris)
            $table->integer('sks_point');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('krs_items');
    }
};
