<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TblSettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_setting')->insert([
            'id' => 1,
            'nama' => 'Masjid Jami Al-Hidayah',
            'alamat' => 'Jl. Raya Keadilan No. 1, Rangkapan Jaya, Pancoran Mas, Kota Depok, Jawa Barat 16434',
            'visi_misi' => "<h3>Visi</h3>\r\n\r\n<p>Menjadi pusat ibadah dan peradaban Islam yang rahmatan lil 'alamin.</p>\r\n\r\n<h3>Misi</h3>\r\n\r\n<ul>\r\n\t<li>Menyelenggarakan ibadah dan kegiatan keislaman secara rutin.</li>\r\n\t<li>Membangun ukhuwah islamiyah antar jamaah.</li>\r\n\t<li>Menjadi pusat pendidikan dan dakwah Islam yang moderat.</li>\r\n</ul>",
            'tentang_kami' => '<h3>Tentang Masjid Jami Al-Hidayah</h3>\r\n\r\n<p>Masjid Jami Al-Hidayah adalah pusat kegiatan keislaman yang berkomitmen untuk melayani umat dan menyebarkan nilai-nilai Islam yang damai dan menyejukkan. Didukung oleh jamaah yang solid, kami menyelenggarakan berbagai kegiatan mulai dari ibadah harian, kajian rutin, hingga kegiatan sosial kemasyarakatan.</p>',
            'wa' => '6281200001111',
            'ig' => 'masjidalhidayah_depok',
            'fb' => 'masjidalhidayahdepok',
            'foto' => null, // Dikosongkan sesuai permintaan
            'logo' => null, // Dikosongkan sesuai permintaan
            'icon' => null, // Dikosongkan sesuai permintaan
            'kota_untuk_sholat' => 'Jakarta',
            'running_text' => 'Selamat Datang di Website Masjid Jami Al-Hidayah. || Kajian Rutin Setiap Sabtu Ba\'da Maghrib.',
            'youtube_url' => null,
            'tiktok_url' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
