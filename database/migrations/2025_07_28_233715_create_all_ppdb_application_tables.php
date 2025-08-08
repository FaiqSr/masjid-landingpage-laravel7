<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CreateAllPpdbApplicationTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Nonaktifkan foreign key check untuk kelancaran proses
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 1. Tabel Admins
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('email', 100)->unique();
            $table->string('password', 100);
            $table->integer('id_role')->comment('1=admin, 2=user');
            $table->timestamps();
        });
        DB::table('admins')->insert([
            'id' => 1, 'name' => 'admin', 'email' => 'admin@localhost.com', 'password' => '$2y$10$vIfeFoJAkJ8jSARMxYjN7.q006OGXZQEq91k7lEspGTnmdmqsnHfy', 'id_role' => 1, 'created_at' => '2025-04-27 07:50:00', 'updated_at' => '2025-04-27 07:50:00'
        ]);

        // 2. Tabel Akun Pendaftar
        Schema::create('akun_pendaftar', function (Blueprint $table) {
            $table->id('id_akun');
            $table->string('email', 191)->unique();
            $table->string('password_hash', 191);
            $table->enum('status_akun', ['Aktif', 'Belum Verifikasi', 'Diblokir'])->default('Belum Verifikasi');
            $table->timestamp('tanggal_dibuat')->useCurrent();
            $table->timestamp('terakhir_login')->nullable();
        });

        // 3. Tabel Failed Jobs
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });

        // 4. Tabel Jalur Pendaftaran
        Schema::create('jalur_pendaftaran', function (Blueprint $table) {
            $table->id('id_jalur');
            $table->string('nama_jalur', 100);
            $table->text('deskripsi')->nullable();
        });
        // Data untuk Jalur Pendaftaran akan diisi oleh Seeder agar lebih rapi,
        // namun bisa juga diisi di sini jika diinginkan.

        // 5. Tabel News
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->string('slug', 191)->unique();
            $table->text('content');
            $table->string('image_url', 100);
            $table->string('admin_photo_url', 100);
            $table->timestamps();
        });
        DB::table('news')->insert([
            ['id' => 1, 'title' => 'Berita PPDB ke-1: Fugiat exercitationem accusantium.', 'slug' => 'berita-ppdb-ke-1-fugiat-exercitationem-accusantium', 'content' => 'Labore quam et veritatis aspernatur...', 'image_url' => 'news1.jpg', 'admin_photo_url' => 'admin.jpg', 'created_at' => '2025-07-28 12:01:21', 'updated_at' => '2025-07-28 12:01:21'],
            ['id' => 2, 'title' => 'Berita PPDB ke-2: Quaerat ut nihil voluptatibus.', 'slug' => 'berita-ppdb-ke-2-quaerat-ut-nihil-voluptatibus', 'content' => 'Iusto molestiae voluptatem quasi quo...', 'image_url' => 'news2.jpg', 'admin_photo_url' => 'admin.jpg', 'created_at' => '2025-07-28 12:01:21', 'updated_at' => '2025-07-28 12:01:21'],
            ['id' => 3, 'title' => 'Berita PPDB ke-3: Cum dignissimos iusto voluptas inventore nemo.', 'slug' => 'berita-ppdb-ke-3-cum-dignissimos-iusto-voluptas-inventore-nemo', 'content' => 'Quia ad ea porro omnis esse alias...', 'image_url' => 'news3.jpg', 'admin_photo_url' => 'admin.jpg', 'created_at' => '2025-07-28 12:01:21', 'updated_at' => '2025-07-28 12:01:21'],
            ['id' => 4, 'title' => 'Berita PPDB ke-4: Rerum dolores illum.', 'slug' => 'berita-ppdb-ke-4-rerum-dolores-illum', 'content' => 'Eaque recusandae dolor fugit deleniti veritatis...', 'image_url' => 'news4.jpg', 'admin_photo_url' => 'admin.jpg', 'created_at' => '2025-07-28 12:01:21', 'updated_at' => '2025-07-28 12:01:21'],
            ['id' => 5, 'title' => 'Berita PPDB ke-5: Corrupti culpa magnam.', 'slug' => 'berita-ppdb-ke-5-corrupti-culpa-magnam', 'content' => 'Possimus consequatur consequatur vel possimus...', 'image_url' => 'news5.jpg', 'admin_photo_url' => 'admin.jpg', 'created_at' => '2025-07-28 12:01:21', 'updated_at' => '2025-07-28 12:01:21'],
            ['id' => 6, 'title' => 'Berita PPDB ke-6: Quae et est.', 'slug' => 'berita-ppdb-ke-6-quae-et-est', 'content' => 'Et dolorem voluptas tenetur nobis illum...', 'image_url' => 'news6.jpg', 'admin_photo_url' => 'admin.jpg', 'created_at' => '2025-07-28 12:01:21', 'updated_at' => '2025-07-28 12:01:21'],
            ['id' => 7, 'title' => 'Berita PPDB ke-7: Est eos dolor maxime nihil.', 'slug' => 'berita-ppdb-ke-7-est-eos-dolor-maxime-nihil', 'content' => 'Non modi dolorem voluptates unde voluptatem...', 'image_url' => 'news7.jpg', 'admin_photo_url' => 'admin.jpg', 'created_at' => '2025-07-28 12:01:21', 'updated_at' => '2025-07-28 12:01:21'],
            ['id' => 8, 'title' => 'Berita PPDB ke-8: Vero voluptatem quia odit voluptate.', 'slug' => 'berita-ppdb-ke-8-vero-voluptatem-quia-odit-voluptate', 'content' => 'Fugiat iusto officiis rem nam...', 'image_url' => 'news8.jpg', 'admin_photo_url' => 'admin.jpg', 'created_at' => '2025-07-28 12:01:21', 'updated_at' => '2025-07-28 12:01:21'],
        ]);

        // 6. Tabel Sliders
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('image_url', 100);
            $table->boolean('is_active')->default(0);
            $table->timestamps();
        });
        DB::table('sliders')->insert([
            'id' => 3, 'image_url' => 'img_20250728193759images.jpg', 'is_active' => 0, 'created_at' => '2025-07-28 12:01:21', 'updated_at' => '2025-07-28 12:37:59'
        ]);

        // 7. Tabel Setting
        Schema::create('tbl_setting', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 191)->nullable();
            $table->text('alamat')->nullable();
            $table->text('visi_misi')->nullable();
            $table->text('tentang_kami')->nullable();
            $table->string('wa', 50)->nullable();
            $table->string('ig', 50)->nullable();
            $table->string('fb', 50)->nullable();
            $table->string('foto', 191)->nullable();
            $table->string('logo', 191)->nullable();
            $table->string('icon', 191)->nullable();
            $table->string('kota_untuk_sholat', 100)->default('Jakarta');
            $table->text('running_text')->nullable();
            $table->string('youtube_url', 191)->nullable();
            $table->string('tiktok_url', 191)->nullable();
            $table->timestamps();
        });
        DB::table('tbl_setting')->insert([
            'id' => 1, 'nama' => 'SMA Harapan Bangsa', 'alamat' => 'Jl. Pendidikan No. 1, Citeureup, Bogor, Jawa Barat', 'visi_misi' => 'Menjadi sekolah unggul...', 'tentang_kami' => 'SMA Harapan Bangsa adalah...', 'wa' => '6281234567890', 'ig' => 'smaharapanbangsa', 'fb' => 'smaharapanbangsa', 'logo' => 'logo.png', 'icon' => 'icon.png', 'kota_untuk_sholat' => 'Bogor', 'running_text' => 'Pendaftaran Peserta Didik Baru Telah Dibuka!', 'created_at' => '2025-07-28 12:01:21', 'updated_at' => '2025-07-28 12:01:21'
        ]);

        // 8. Tabel Users
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 191);
            $table->string('email', 191)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 191);
            $table->rememberToken();
            $table->timestamps();
        });
        DB::table('users')->insert([
            'id' => 1, 'name' => 'Test User', 'email' => 'user@ppdb.com', 'email_verified_at' => '2025-07-28 12:01:21', 'password' => '$2y$10$ys9GC..UMuDWljIFqigubu0/GRa/bgCFW7MFYClkDlSnH/zdoC2QS', 'created_at' => '2025-07-28 12:01:21', 'updated_at' => '2025-07-28 12:01:21'
        ]);

        // 9. Tabel Calon Siswa (dengan foreign key)
        Schema::create('calon_siswa', function (Blueprint $table) {
            $table->id('id_siswa');
            $table->foreignId('id_akun')->constrained('akun_pendaftar', 'id_akun')->onDelete('cascade');
            $table->string('nomor_pendaftaran', 20)->unique();
            $table->string('nama_lengkap', 191);
            $table->string('nisn', 10)->unique();
            $table->string('nik', 16)->unique();
            $table->string('no_kk', 16)->unique();
            $table->string('tempat_lahir', 100);
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('agama', 50);
            $table->text('alamat_lengkap');
            $table->integer('anak_ke');
            $table->integer('jumlah_saudara');
            $table->string('sekolah_asal', 191);
            $table->year('tahun_lulus');
            $table->foreignId('id_jalur_pendaftaran')->constrained('jalur_pendaftaran', 'id_jalur');
            $table->enum('status_pendaftaran', ['Draft', 'Menunggu Verifikasi', 'Terverifikasi', 'Diterima', 'Ditolak', 'Cadangan'])->default('Draft');
            $table->enum('status_pemberkasan', ['Sudah', 'Belum'])->default('Belum');
            $table->timestamp('tanggal_registrasi')->useCurrent();
        });
        
        // 10. Tabel Orang Tua Wali (dengan foreign key)
        Schema::create('orang_tua_wali', function (Blueprint $table) {
            $table->id('id_ortu');
            $table->foreignId('id_siswa')->constrained('calon_siswa', 'id_siswa')->onDelete('cascade');
            $table->enum('hubungan', ['Ayah', 'Ibu', 'Wali']);
            $table->string('nama_lengkap', 191);
            $table->string('nik', 16)->nullable();
            $table->string('pendidikan_terakhir', 50)->nullable();
            $table->string('pekerjaan', 100)->nullable();
            $table->decimal('penghasilan_bulanan', 15, 2)->nullable();
            $table->string('no_telepon_ortu', 15)->nullable();
        });

        // 11. Tabel Berkas Pendaftaran (dengan foreign key)
        Schema::create('berkas_pendaftaran', function (Blueprint $table) {
            $table->id('id_berkas');
            $table->foreignId('id_siswa')->constrained('calon_siswa', 'id_siswa')->onDelete('cascade');
            $table->string('jenis_berkas', 100);
            $table->string('nama_file_asli', 191);
            $table->string('path_file', 191);
            $table->enum('status_verifikasi', ['Menunggu Verifikasi', 'Valid', 'Tidak Valid'])->default('Menunggu Verifikasi');
            $table->text('catatan_verifikator')->nullable();
            $table->timestamp('tanggal_upload')->useCurrent();
        });

        DB::table('jalur_pendaftaran')->insert([
            ['nama_jalur' => 'Zonasi', 'deskripsi' => 'Berdasarkan jarak tempat tinggal ke sekolah'],
            ['nama_jalur' => 'Afirmasi', 'deskripsi' => 'Untuk siswa dari keluarga tidak mampu atau disabilitas'],
            ['nama_jalur' => 'Prestasi Akademik', 'deskripsi' => 'Berdasarkan nilai rapor dan prestasi akademik lainnya'],
            ['nama_jalur' => 'Prestasi Non-Akademik', 'deskripsi' => 'Berdasarkan prestasi di bidang olahraga, seni, dll.'],
            ['nama_jalur' => 'Pindah Tugas Orang Tua/Wali', 'deskripsi' => 'Untuk anak dari orang tua yang pindah tugas'],
        ]);

        // Aktifkan kembali foreign key check
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Hapus tabel dalam urutan terbalik untuk menghindari error foreign key
        Schema::dropIfExists('berkas_pendaftaran');
        Schema::dropIfExists('orang_tua_wali');
        Schema::dropIfExists('calon_siswa');
        Schema::dropIfExists('users');
        Schema::dropIfExists('tbl_setting');
        Schema::dropIfExists('sliders');
        Schema::dropIfExists('news');
        Schema::dropIfExists('jalur_pendaftaran');
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('akun_pendaftar');
        Schema::dropIfExists('admins');
    }
}