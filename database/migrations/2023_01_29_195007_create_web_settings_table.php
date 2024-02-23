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
        Schema::create('web_settings', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('site_name')->nullable();
            $table->string('short_name')->nullable();
            $table->string('institution_name')->nullable();
            $table->string('institution_synopsis')->nullable();
            $table->string('title_home')->nullable();
            $table->string('title_dashboard')->nullable();
            $table->string('title_exam')->nullable();

            $table->text('footer')->nullable();
            $table->string('link_univ')->nullable();

            $table->string('contact_telp')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_fax')->nullable();
            $table->string('contact_address')->nullable();
            $table->string('contact_maps')->nullable();
            $table->string('contact_maps_link')->nullable();
            $table->string('contact_facebook')->nullable();
            $table->string('contact_whatsapp')->nullable();
            $table->string('contact_instagram')->nullable();
            $table->string('contact_twitter')->nullable();
            $table->string('contact_youtube')->nullable();

            // Payment
            $table->string('payment_bank')->nullable();
            $table->string('payment_account')->nullable();
            $table->string('payment_name')->nullable();


            $table->timestamps();
        });

        DB::table('web_settings')->insert([
            'name' => 'Spmb Hangtuah',
            'site_name' => 'PMB Hang Tuah',
            'short_name' => 'PMB HTP',
            'institution_name' => 'Universitas Hang Tuah Pekanbaru',
            'institution_synopsis' => 'UHT Pekanbaru mempunyai tata nilai budaya akademik yang khas yaitu BERTUAH mempunyai makna bahwa setiap lulusan Universitas Hang Tuah Pekanbaru harus memiliki kualifikasi',
            'title_home' => 'Hang Tuah Pekanbaru',
            'title_dashboard' => 'PMB',
            'title_exam' => 'CBT',
            'footer' => '© 2023 University Hang Tuah Pekanbaru.',
            'contact_telp' => '081234567890',
            'contact_email' => 'admin@gmail.com',
            'contact_fax' => '+ 0761 33815',
            'contact_address' => 'Jl. Mustafa Sari No.5, Tengkerang Sel., Kec. Bukit Raya, Kota Pekanbaru, Riau 28281',
            'contact_maps' => 'https://www.google.com/maps/place/Universitas+Hang+Tuah+Pekanbaru/@0.4826435,101.4582083,16z/data=!4m6!3m5!1s0x31d5aee753f76eb1:0x659cba40a618901b!8m2!3d0.4827927!4d101.4563443!16s%2Fg%2F1tgpvq07?entry=ttu',
            'contact_maps_link' => 'https://www.google.com/maps/embed/v1/place?q=place_id:ChIJsW73U-eu1TERG5AYpkC6nGU&key=AIzaSyBFw0Qbyq9zTFTd-tUY6dZWTgaQzuU17R8',
            'contact_facebook' => 'https://www.facebook.com/UniversitasHangTuahPekanbaru',
            'contact_whatsapp' => '+ 0761 33815',
            'contact_instagram' => 'https://www.instagram.com/univ.hangtuahpekanbaru',
            'contact_twitter' => '',
            'contact_youtube' => 'https://www.youtube.com/@UniversitasHangTuahPekanbaru',
            'link_univ' => 'https://www.hangtuah.ac.id',
            'payment_bank' => 'Bank BTN',
            'payment_account' => '00323-01-30-000028-7',
            'payment_name' => 'Universitas Hang Tuah Pekanbaru',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('web_settings');
    }
};
