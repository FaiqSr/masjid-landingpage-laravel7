<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengaturanPpdbController extends Controller
{
    /**
     * Menampilkan halaman utama pengaturan PPDB (daftar tahun ajaran).
     */
    public function index()
    {
        $tahun_ajaran = DB::table('tahun_ajaran')->orderBy('tahun_ajaran', 'desc')->get();

        return view('dashboard.pengaturan.index', [
            'title' => 'Pengaturan PPDB',
            'tahun_ajaran' => $tahun_ajaran,
        ]);
    }

    /**
     * Menyimpan tahun ajaran baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tahun_ajaran' => 'required|string|max:9|unique:tahun_ajaran,tahun_ajaran|regex:/^\d{4}\/\d{4}$/',
            'status' => 'required|in:Aktif,Tidak Aktif',
        ], [
            'tahun_ajaran.required' => 'Kolom tahun ajaran wajib diisi.',
            'tahun_ajaran.unique' => 'Tahun ajaran ini sudah ada.',
            'tahun_ajaran.regex' => 'Format tahun ajaran salah. Gunakan format YYYY/YYYY, contoh: 2025/2026.',
        ]);

        DB::beginTransaction();
        try {
            // Jika status yang baru adalah "Aktif", nonaktifkan semua yang lain terlebih dahulu
            if ($request->status == 'Aktif') {
                DB::table('tahun_ajaran')->update(['status' => 'Tidak Aktif']);
            }

            // Masukkan data baru
            DB::table('tahun_ajaran')->insert([
                'tahun_ajaran' => $request->tahun_ajaran,
                'status' => $request->status,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();
            return redirect()->route('pengaturan.index')->with('sukses', 'Tahun ajaran berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('pengaturan.index')->with('gagal', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Mengatur sebuah tahun ajaran menjadi aktif.
     */
    public function setActive($id)
    {
        DB::beginTransaction();
        try {
            // 1. Nonaktifkan semua tahun ajaran
            DB::table('tahun_ajaran')->update(['status' => 'Tidak Aktif']);
            
            // 2. Aktifkan satu tahun ajaran yang dipilih
            DB::table('tahun_ajaran')->where('id_tahun_ajaran', $id)->update(['status' => 'Aktif']);
            
            DB::commit();
            return redirect()->route('pengaturan.index')->with('sukses', 'Status tahun ajaran berhasil diubah.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('pengaturan.index')->with('gagal', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus tahun ajaran.
     */
    public function destroy($id)
    {
        // Pengecekan keamanan: jangan hapus jika sudah ada siswa terdaftar
        $siswa_count = DB::table('calon_siswa')->where('id_tahun_ajaran', $id)->count();

        if ($siswa_count > 0) {
            return redirect()->route('pengaturan.index')->with('gagal', 'Gagal! Tahun ajaran ini tidak dapat dihapus karena sudah memiliki data pendaftar.');
        }

        // Hapus jika aman
        DB::table('tahun_ajaran')->where('id_tahun_ajaran', $id)->delete();
        return redirect()->route('pengaturan.index')->with('sukses', 'Tahun ajaran berhasil dihapus.');
    }
}