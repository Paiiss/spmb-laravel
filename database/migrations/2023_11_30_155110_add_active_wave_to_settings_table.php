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
        Schema::create('waves', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('gelombang')->nullable();
            $table->string('tahun_akademik')->nullable();
            $table->date('awal_daftar')->nullable();
            $table->date('akhir_daftar')->nullable();
            $table->date('tes_tulis')->nullable();
            $table->date('tes_kesehatan')->nullable();
            $table->date('wawancara')->nullable();
            $table->boolean('active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waves');
    }
};
