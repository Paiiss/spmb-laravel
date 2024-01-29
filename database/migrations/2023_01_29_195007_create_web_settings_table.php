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
            $table->string('title_home')->nullable();
            $table->string('title_dashboard')->nullable();

            $table->text('footer')->nullable();
            $table->string('link_univ')->nullable();

            $table->string('contact_telp')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_fax')->nullable();
            $table->string('contact_address')->nullable();
            $table->string('contact_maps')->nullable();
            $table->string('contact_facebook')->nullable();
            $table->string('contact_whatsapp')->nullable();
            $table->string('contact_instagram')->nullable();
            $table->string('contact_twitter')->nullable();
            $table->string('contact_youtube')->nullable();
        });

        DB::table('web_settings')->insert([
            'name' => 'Spmb Hangtuah',
            'title_home' => 'PMB 2024/2025',
            'title_dashboard' => 'PMB',
            'footer' => '© 2023 University Hang Tuah Pekanbaru.',
            'contact_telp' => '081234567890',
            'contact_email' => 'admin@gmail.com',
            'contact_fax' => '+ 0761 33815',
            'contact_address' => 'Jl. Mustafa Sari No.5, Tengkerang Sel., Kec. Bukit Raya, Kota Pekanbaru, Riau 28281',
            'contact_maps' => 'https://www.google.com/maps/place/Universitas+Hang+Tuah+Pekanbaru/@0.4826435,101.4582083,16z/data=!4m6!3m5!1s0x31d5aee753f76eb1:0x659cba40a618901b!8m2!3d0.4827927!4d101.4563443!16s%2Fg%2F1tgpvq07?entry=ttu',
            'contact_facebook' => '',
            'contact_whatsapp' => '+ 0761 33815',
            'contact_instagram' => '',
            'contact_twitter' => '',
            'contact_youtube' => '',
            'link_univ' => 'https://www.hangtuah.ac.id',
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
