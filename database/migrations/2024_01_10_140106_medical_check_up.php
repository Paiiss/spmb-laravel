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
        Schema::create('medical_check_up', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');

            $table->integer('height')->nullable();
            $table->integer('weight')->nullable();
            $table->string('blood_type')->nullable();
            $table->integer('blood_pressure')->nullable();
            $table->integer('blood_sugar')->nullable();
            $table->boolean('is_smoking')->default(false);
            $table->boolean('color_blind')->default(false);
            $table->boolean('is_disability')->default(false);
            $table->text('note')->nullable();

            $table->enum('status', ['waiting', 'submitted', 'approved', 'rejected'])->default('waiting');
            $table->text('admin_note')->nullable();
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
