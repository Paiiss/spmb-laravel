# Sistem pendaftaran mahasiswa baru

Proyek ini adalah sebuah aplikasi berbasis Laravel yang dirancang khusus untuk membantu kampus/sekolah dalam proses penerimaan mahasiswa/siswa baru. Dengan antarmuka yang intuitif dan fitur yang lengkap, aplikasi ini memungkinkan calon mahasiswa/siswa untuk mendaftar secara online dengan mudah dan efisien.

## Features

-   Pendaftaran Online: Calon mahasiswa/siswa dapat mengisi formulir pendaftaran secara online dengan detail pribadi, riwayat pendidikan, dan informasi lainnya.
-   Upload Dokumen: Fasilitas untuk mengunggah dokumen-dokumen penting seperti transkrip nilai, dan dokumen identitas.
-   Sistem Ujian Online:
    -   Kemampuan untuk membuat dan menjadwalkan ujian online dengan berbagai jenis pertanyaan seperti pilihan ganda.
    -   Pelacakan waktu ujian dan pembatasan waktu untuk setiap sesi ujian.
    -   Penilaian otomatis jawaban dan penyediaan laporan hasil ujian untuk dianalisis oleh pantia atau administrator.
-   Pengecekan Kesehatan:
    -   Formulir pengecekan kesehatan online untuk calon mahasiswa/siswa yang mencakup riwayat medis, gejala, dan informasi kesehatan penting lainnya.
    -   Kemampuan untuk mengunggah dokumen-dokumen medis yang relevan seperti hasil tes laboratorium dan catatan medis.
-   Wawancara Online:
    -   Formulir untuk pelaksanaan wawancara secara online antara calon mahasiswa/siswa dah pantia.
-   Notifikasi:
    -   Sistem notifikasi yang kuat untuk memberi tahu calon mahasiswa/siswa tentang status pendaftaran.

## Tech Stack

-   **Client:** Tailwind CSS, Vue.js, Inertia.js, Vite

-   **Server:** Laravel, MySQL

## Demo

-   [Sistem Pendaftaran Mahasiswa Baru](https://spmb.peix.my.id)

## Instalasi

Berikut langkah-langkah untuk menginstal dan menjalankan proyek:

1. Clone repository:

    ```bash
    git clone https://github.com/Paiiss/spmb-laravel.git
    ```

2. Instal dependensi menggunakan Composer:

    ```bash
    composer install
    ```

3. Salin file `.env.example` menjadi `.env` dan sesuaikan konfigurasi database:

    ```bash
    cp .env.example .env
    ```

4. Buat kunci aplikasi:

    ```bash
    php artisan key:generate
    ```

5. Jalankan migrasi untuk membuat tabel-tabel database:

    ```bash
    php artisan migrate
    ```

6. Jalankan server pengembangan:

    ```bash
    php artisan serve
    ```

## Support

Jika Anda ingin mendukung pengembangan proyek ini, Anda dapat memberikan donasi melalui [saweria](https://saweria.co/pais). Setiap kontribusi sangat dihargai dan akan digunakan untuk memperbaiki dan memperluas fitur-fitur proyek ini.

Selain itu, saya juga menyediakan layanan instalasi proyek ini untuk membantu Anda menerapkannya dalam lingkungan produksi Anda. Layanan instalasi mencakup konfigurasi, penyesuaian, dan implementasi proyek sesuai dengan kebutuhan Anda.

Jika Anda memerlukan bantuan dalam instalasi proyek ini atau memiliki pertanyaan lebih lanjut, jangan ragu untuk menghubungi saya melalui email di [mfa.daffa@gmail.com](mailto:mfa.daffa@gmail.com).

## Peringatan

Proyek ini dilindungi oleh hak cipta dan lisensi [MIT](https://github.com/Paiiss/spmb-laravel/blob/main/LICENSE). Dilarang keras untuk menjual ulang atau mendistribusikan kembali kode sumber ini tanpa izin tertulis dari pemilik proyek.

Segala bentuk pelanggaran terhadap hak cipta dan lisensi akan ditindaklanjuti sesuai dengan hukum yang berlaku.

Terima kasih atas pengertian dan kerjasamanya.
