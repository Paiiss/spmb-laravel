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
        Schema::create('medical_check_up', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');

            $table->integer('height')->nullable();
            $table->integer('weight')->nullable();
            $table->string('blood_type')->nullable();
            $table->integer('blood_pressure')->nullable();
            $table->integer('blood_sugar')->nullable();
            $table->boolean('is_smoking')->nullable();
            $table->boolean('color_blind')->nullable();
            $table->boolean('is_disability')->nullable();
            $table->string('vision')->nullable();
            $table->string('history_of_disease')->nullable();
            $table->string('note')->nullable();
            $table->string('image')->nullable();

            $table->string('status')->default('pending');
            $table->boolean('is_approved')->nullable();
            $table->boolean('is_rejected')->nullable();
            $table->string('rejected_note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_check_up');
    }
};
