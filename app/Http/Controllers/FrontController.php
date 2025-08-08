<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FrontController extends Controller
{
    public function login_page()
    {
        return view('auth.login');
    }

    public function beranda()
    {
        return view('beranda');
    }

    public function profil()
    {
        $setting = DB::table('tbl_setting')->first();

        if (!$setting) {
            abort(404, 'Halaman profil tidak dapat ditemukan.');
        }

        return view('profil', ['setting' => $setting]);
    }


    public function pengumumanDetail($slug)
    {
        $pengumuman = DB::table('pengumuman')->where('slug', $slug)->first();

        // Jika pengumuman tidak ditemukan, tampilkan error 404
        if (!$pengumuman) {
            abort(404);
        }

        // Ambil 5 pengumuman terbaru, kecuali yang sedang dibuka
        $other_announcements = DB::table('pengumuman')
            ->where('id', '!=', $pengumuman->id) // <-- Mengecualikan pengumuman saat ini
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Kirim semua data yang diperlukan ke view
        return view('pengumuman.detail', [
            'pengumuman' => $pengumuman,
            'other_announcements' => $other_announcements
        ]);
    }

    public function kontak()
    {
        // Ambil satu baris data dari tabel pengaturan
        $setting = DB::table('tbl_setting')->first();

        // Kirim data ke view 'kontak.blade.php'
        return view('kontak', [
            'title' => 'Kontak Kami',
            'setting' => $setting
        ]);
    }

    public function berita()
    {
        $data = DB::table('news')->paginate(6);

        return view('artikel.berita', ['data' => $data]);
    }

    public function beritaDetail($slug)
    {
        $new = DB::table('news')->where('slug', $slug)->first();

        if (!$new) {
            abort(404);
        }

        $recent_news = DB::table('news')
            ->where('id', '!=', $new->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('artikel.detail', [
            'new' => $new,
            'recent_news' => $recent_news
        ]);
    }

    public function galery()
    {
        $data = DB::table('galery')->paginate(16);

        return view('galery.index', compact('data'));
    }

    public function paketDetail($id)
    {
        $paket = DB::table('paket')
            // Join ke tabel paket_type untuk mendapatkan nama tipe
            ->join('paket_type', 'paket.id_paket_type', '=', 'paket_type.id')
            // Join ke tabel hotel SEBAGAI hotel_makkah
            ->join('hotel as hotel_makkah', 'paket.id_hotel_makkah', '=', 'hotel_makkah.id')
            // Join ke tabel hotel SEBAGAI hotel_madinah
            ->join('hotel as hotel_madinah', 'paket.id_hotel_madinah', '=', 'hotel_madinah.id')
            // Join ke tabel maskapai
            ->join('maskapai', 'paket.id_maskapai', '=', 'maskapai.id')
            ->select(
                'paket.*',
                'paket_type.nama as nama_tipe_paket',
                'hotel_makkah.nama as nama_hotel_makkah',
                'hotel_makkah.level as level_hotel_makkah',
                'hotel_madinah.nama as nama_hotel_madinah',
                'hotel_madinah.level as level_hotel_madinah',
                'maskapai.nama as nama_maskapai'
            )
            ->where('paket.id', $id)
            ->first();

        // Jika paket tidak ditemukan, tampilkan halaman 404
        if (!$paket) {
            abort(404, 'Paket tidak ditemukan.');
        }

        // 2. Ambil data fasilitas untuk paket ini
        $fasilitas = DB::table('paket_fasilitas')
            ->join('fasilitas', 'paket_fasilitas.id_fasilitas', '=', 'fasilitas.id')
            ->where('paket_fasilitas.id_paket', $id)
            ->get();

        // 3. Kirim data ke view
        return view('paket.detail', [
            'paket' => $paket,
            'fasilitas' => $fasilitas
        ]);
    }

    public function layanan()
    {
        $data = DB::table('layanan')->paginate(10);

        return view('layanan.index', compact('data'));
    }

    public function layananDetail($id)
    {
        $layanan = DB::table('layanan')->where('id', $id)->first();

        return view('layanan.detail', compact('layanan'));
    }

    public function pengumuman()
    {
        $pengumuman = DB::table('pengumuman')->orderBy('created_at', 'desc')->paginate(9);

        return view('pengumuman.index', ['pengumuman' => $pengumuman]);
    }

    /**
     * Menampilkan daftar laporan keuangan dengan pagination.
     */
    public function keuanganList()
    {
        $laporan = DB::table('keuangan_header')
            ->orderBy('periode', 'desc')
            ->paginate(10); // Menampilkan 10 laporan per halaman

        return view('keuangan.index', ['laporan' => $laporan]);
    }

    /**
     * Menampilkan detail transaksi dari sebuah laporan keuangan.
     */
    public function keuanganDetail($id)
    {
        $header = DB::table('keuangan_header')->find($id);

        if (!$header) {
            abort(404);
        }

        $detail = DB::table('keuangan_detail')
            ->where('header_id', $id)
            ->orderBy('tanggal_transaksi', 'asc')
            ->get();

        // Mengambil data untuk sidebar
        $layanan_list = DB::table('layanan')->limit(5)->get();
        $recent_news = DB::table('news')->orderBy('created_at', 'desc')->limit(5)->get();

        // Mengirim semua data yang diperlukan ke view
        return view('keuangan.show', compact(
            'header',
            'detail',
            'layanan_list',
            'recent_news'
        ));
    }
}
