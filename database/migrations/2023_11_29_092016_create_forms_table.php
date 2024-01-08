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
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');

            // Personal
            $table->string('gender')->nullable();
            $table->string('religion')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('birth_place_city')->nullable();
            $table->string('birth_place_province')->nullable();
            $table->string('birth_place_country')->nullable();
            $table->integer('national_id')->nullable();

            // Disabilitas
            $table->boolean('is_color_blind')->nullable();
            $table->boolean('is_disability')->nullable();
            $table->string('disability_note')->nullable();

            // Address
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('subdistrict')->nullable();
            $table->string('country')->nullable();
            $table->integer('postal_code')->nullable();
            $table->integer('rt')->nullable();
            $table->integer('rw')->nullable();

            // Contact
            $table->string('phone_number')->nullable();
            $table->string('phone_number_alt')->nullable();

            // Last education
            $table->string('last_education')->nullable();

            // Education
            $table->integer('education_number')->nullable();
            $table->string('education_name')->nullable();
            $table->string('education_city')->nullable();
            $table->string('education_province')->nullable();
            $table->string('education_subdistrict')->nullable();
            $table->string('education_country')->nullable();
            $table->integer('education_postal_code')->nullable();
            $table->string('education_graduation_year')->nullable();
            $table->string('education_major')->nullable();
            $table->string('education_grade')->nullable();

            // Parent father
            $table->string('father_name')->nullable();
            $table->string('father_birth_date')->nullable();
            $table->string('father_place')->nullable();
            $table->string('father_last_education')->nullable();
            $table->string('father_job')->nullable();
            $table->string('father_phone')->nullable();
            $table->string('father_email')->nullable();


            // Parent mother
            $table->string('mother_name')->nullable();
            $table->string('mother_birth_date')->nullable();
            $table->string('mother_place')->nullable();
            $table->string('mother_last_education')->nullable();
            $table->string('mother_job')->nullable();
            $table->string('mother_email')->nullable();
            $table->string('mother_phone')->nullable();

            // Parent guardian
            $table->string('guardian_name')->nullable();
            $table->string('guardian_birth_date')->nullable();
            $table->string('guardian_place')->nullable();
            $table->string('guardian_last_education')->nullable();
            $table->string('guardian_job')->nullable();
            $table->string('guardian_email')->nullable();
            $table->string('guardian_phone')->nullable();

            // Affiliate
            $table->foreignId('affiliate_id')->nullable()->constrained('affiliates')->cascadeOnDelete()->cascadeOnUpdate();


            // No Ujian
            $table->string('no_ujian')->nullable();

            // Status
            $table->string('registration_waves')->nullable();
            $table->boolean('is_lock')->default(false);
            $table->boolean('is_submitted')->default(false);
            $table->boolean('is_accepted')->default(false);
            $table->boolean('is_rejected')->default(false);
            $table->boolean('is_paid_registration')->default(false);
            $table->boolean('is_paid_tuition')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forms');
    }
};
