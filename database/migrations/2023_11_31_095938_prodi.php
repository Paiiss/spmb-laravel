<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("prodi", function (Blueprint $table) {
            $table->id();
            $table->string("nama_prodi")->nullable();
            $table->string("jenjang")->nullable();
            $table->string("fakultas")->nullable();
            $table->string("akreditasi")->nullable();
            $table->boolean('tes_ujian')->default(false);
            $table->string('ujian')->nullable();
            $table->integer('nilai_dibawah')->nullable();
            $table->boolean('tes_wawancara')->default(false);
            $table->boolean('tes_kesehatan')->default(false);
            $table->integer('biaya_registrasi')->default(0);
            $table->boolean("status")->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prodi');
    }
};
