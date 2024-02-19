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
        Schema::create('forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');

            // Personal
            $table->string('gender')->nullable();
            $table->string('religion')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('birth_place_city')->nullable();
            $table->string('birth_place_province')->nullable();
            $table->string('birth_place_country')->default('Indonesia');
            $table->string('national_id')->nullable();

            // Disabilitas
            $table->boolean('is_color_blind')->nullable();
            $table->boolean('is_disability')->nullable();
            $table->text('disability_note')->nullable();

            // Address
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('subdistrict')->nullable();
            $table->string('country')->default('Indonesia');
            $table->string('postal_code')->nullable();
            $table->string('rt')->nullable();
            $table->string('rw')->nullable();

            // Contact
            $table->string('phone_number')->nullable();
            $table->string('phone_number_alt')->nullable();

            // Last education
            $table->string('last_education')->nullable();

            // Education
            $table->string('education_number')->nullable();
            $table->string('education_name')->nullable();
            $table->string('education_city')->nullable();
            $table->string('education_province')->nullable();
            $table->string('education_subdistrict')->nullable();
            $table->string('education_country')->default('Indonesia');
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
            $table->string('guardian_relation')->nullable();

            // Affiliate
            $table->foreignId('affiliate_id')->nullable()->constrained('affiliates')->cascadeOnDelete()->cascadeOnUpdate();

            // No Ujian
            $table->string('no_exam')->nullable();
            $table->string('code_registration')->default(0);

            // Status
            $table->foreignId('wave_id')->nullable()->constrained('waves')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('option_id')->nullable()->constrained('prodi');
            $table->foreignId('option_2_id')->nullable()->constrained('prodi');

            $table->boolean('is_via_online')->default(true);
            $table->boolean('is_lock')->default(false);
            $table->boolean('is_submitted')->default(false);
            $table->text('note')->nullable();
            $table->enum('status', ['waiting', 'submitted', 'pending', 'approved', 'rejected'])->default('waiting');
            $table->text('reason_rejected')->nullable();
            $table->enum('end_status', ['pending', 'submitted', 'approved', 'rejected'])->default('pending');
            $table->timestamp('is_paid_registration')->nullable();
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
