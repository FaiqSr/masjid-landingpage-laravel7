<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllMasjidTables extends Migration
{
    /**
     * Jalankan migrasi.
     *
     * @return void
     */
    public function up()
    {
        // Tabel standar Laravel untuk jobs yang gagal
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });

        // Tabel standar Laravel untuk pengguna
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        // Tabel custom untuk admin
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('email', 100)->unique();
            $table->string('password', 100);
            $table->integer('id_role')->comment('1=admin, 2=user');
            $table->timestamps();
        });

        // Tabel untuk galeri foto
        Schema::create('galery', function (Blueprint $table) {
            $table->id();
            $table->text('url');
            $table->text('detail');
            $table->timestamps();
        });

        // Tabel untuk layanan masjid
        Schema::create('layanan', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama', 100);
            $table->string('petugas', 100);
            $table->string('kontak', 30);
            $table->text('foto');
            $table->timestamps(); // Ditambahkan
        });

        // Tabel untuk berita atau artikel
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->string('slug')->unique();
            $table->text('content');
            $table->string('image_url', 100);
            $table->string('admin_photo_url', 100);
            $table->timestamps();
        });

        // Tabel untuk pengumuman
        Schema::create('pengumuman', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('foto');
            $table->text('content');
            $table->timestamps(); // Ditambahkan
        });

        // Tabel untuk struktur pengurus DKM
        Schema::create('pengurus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama', 150);
            $table->string('jabatan', 100);
            $table->text('foto');
            $table->timestamps(); // Ditambahkan
        });

        // Tabel untuk jadwal petugas harian (imam & muadzin)
        Schema::create('petugas_harian', function (Blueprint $table) {
            $table->increments('id');
            $table->string('waktu', 20);
            $table->string('imam', 100)->nullable();
            $table->string('muadzin', 100)->nullable();
            $table->timestamps(); // Ditambahkan
        });

        // Tabel untuk gambar slider di halaman utama
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('image_url', 100);
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });

        // Tabel untuk pengaturan umum website
        Schema::create('tbl_setting', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->nullable();
            $table->text('alamat')->nullable();
            $table->text('visi_misi')->nullable();
            $table->text('tentang_kami')->nullable();
            $table->string('wa', 50)->nullable();
            $table->string('ig', 50)->nullable();
            $table->string('fb', 50)->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('tiktok_url')->nullable();
            $table->timestamps(); // Ditambahkan
        });
    }

    /**
     * Batalkan migrasi.
     *
     * @return void
     */
    public function down()
    {
        // Drop tabel dalam urutan terbalik dari pembuatannya untuk menghindari masalah foreign key
        Schema::dropIfExists('tbl_setting');
        Schema::dropIfExists('sliders');
        Schema::dropIfExists('petugas_harian');
        Schema::dropIfExists('pengurus');
        Schema::dropIfExists('pengumuman');
        Schema::dropIfExists('news');
        Schema::dropIfExists('layanan');
        Schema::dropIfExists('galery');
        Schema::dropIfExists('admins');
        Schema::dropIfExists('users');
        Schema::dropIfExists('failed_jobs');
    }
}