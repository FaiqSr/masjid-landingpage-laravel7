<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PpdbAdminController extends Controller
{
    /**
     * Menampilkan halaman daftar calon siswa pendaftar PPDB.
     */
    public function index(Request $request)
    {
        $semua_tahun_ajaran = DB::table('tahun_ajaran')->orderBy('tahun_ajaran', 'desc')->get();

        // Cek apakah ada filter tahun ajaran dari request, jika tidak, gunakan yang aktif
        $id_tahun_ajaran_filter = $request->input('tahun_ajaran', $semua_tahun_ajaran->where('status', 'Aktif')->first()->id_tahun_ajaran ?? null);

        $query = DB::table('calon_siswa')->join('jalur_pendaftaran', 'calon_siswa.id_jalur_pendaftaran', '=', 'jalur_pendaftaran.id_jalur');

        // Terapkan filter jika ada
        if ($id_tahun_ajaran_filter) {
            $query->where('calon_siswa.id_tahun_ajaran', $id_tahun_ajaran_filter);
        }

        $pendaftar = $query->select('calon_siswa.*', 'jalur_pendaftaran.nama_jalur')->orderBy('calon_siswa.id_siswa', 'desc')->get();

        $data = [
            'title' => 'Data Pendaftar PPDB',
            'pendaftar' => $pendaftar,
            'semua_tahun_ajaran' => $semua_tahun_ajaran,
            'id_filter' => $id_tahun_ajaran_filter,
        ];
        return view('dashboard.ppdb.index', $data);
    }

    /**
     * Menampilkan detail lengkap data seorang pendaftar.
     */
    public function show($id)
    {
        $siswa = DB::table('calon_siswa')->join('jalur_pendaftaran', 'calon_siswa.id_jalur_pendaftaran', '=', 'jalur_pendaftaran.id_jalur')->join('akun_pendaftar', 'calon_siswa.id_akun', '=', 'akun_pendaftar.id_akun')->select('calon_siswa.*', 'jalur_pendaftaran.nama_jalur', 'akun_pendaftar.email')->where('calon_siswa.id_siswa', $id)->first();

        if (!$siswa) {
            abort(404, 'Data Siswa Tidak Ditemukan');
        }

        $orang_tua = DB::table('orang_tua_wali')->where('id_siswa', $id)->get();
        $berkas = DB::table('berkas_pendaftaran')->where('id_siswa', $id)->get();

        $data = [
            'title' => 'Detail Pendaftar: ' . $siswa->nama_lengkap,
            'siswa' => $siswa,
            'orang_tua' => $orang_tua,
            'berkas' => $berkas,
        ];

        return view('dashboard.ppdb.show', $data);
    }

    /**
     * Menampilkan form untuk mengedit data pendaftar.
     */
    public function edit($id)
    {
        $siswa = DB::table('calon_siswa')->where('id_siswa', $id)->first();

        if (!$siswa) {
            abort(404, 'Data Siswa Tidak Ditemukan');
        }

        $jalur_pendaftaran = DB::table('jalur_pendaftaran')->get();

        $data = [
            'title' => 'Edit Pendaftar: ' . $siswa->nama_lengkap,
            'siswa' => $siswa,
            'jalur_pendaftaran' => $jalur_pendaftaran,
        ];

        return view('dashboard.ppdb.edit', $data);
    }

    /**
     * Memproses pembaruan data dari form edit.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:191',
            'nisn' => 'required|numeric|digits:10|unique:calon_siswa,nisn,' . $id . ',id_siswa',
            'status_pendaftaran' => 'required|in:Draft,Menunggu Verifikasi,Terverifikasi,Diterima,Ditolak,Cadangan',
            'id_jalur_pendaftaran' => 'required|exists:jalur_pendaftaran,id_jalur',
        ]);

        if ($validator->fails()) {
            return redirect()->route('ppdb.edit', $id)->withErrors($validator)->withInput();
        }

        // Data untuk diupdate
        $updateData = [
            'nama_lengkap' => $request->input('nama_lengkap'),
            'nisn' => $request->input('nisn'),
            'nik' => $request->input('nik'),
            'tempat_lahir' => $request->input('tempat_lahir'),
            'tanggal_lahir' => $request->input('tanggal_lahir'),
            'jenis_kelamin' => $request->input('jenis_kelamin'),
            'sekolah_asal' => $request->input('sekolah_asal'),
            'tahun_lulus' => $request->input('tahun_lulus'),
            'status_pendaftaran' => $request->input('status_pendaftaran'),
            'id_jalur_pendaftaran' => $request->input('id_jalur_pendaftaran'),
        ];

        // Lakukan update
        DB::table('calon_siswa')->where('id_siswa', $id)->update($updateData);

        return redirect()->route('ppdb.index')->with('success', 'Data siswa berhasil diperbarui!');
    }

    /**
     * Menghapus data pendaftar.
     */
    public function destroy($id)
    {
        // Cari data siswa
        $siswa = DB::table('calon_siswa')->where('id_siswa', $id)->first();
        if (!$siswa) {
            return redirect()->route('ppdb.index')->with('error', 'Data tidak ditemukan.');
        }

        // Dapatkan path berkas sebelum menghapus record database
        $berkas = DB::table('berkas_pendaftaran')->where('id_siswa', $id)->get();

        DB::beginTransaction();
        try {
            // Hapus record dari database (termasuk ortu, pilihan, berkas karena onDelete('cascade'))
            DB::table('akun_pendaftar')->where('id_akun', $siswa->id_akun)->delete();

            // Hapus file fisik dari storage
            foreach ($berkas as $file) {
                // path_file disimpan dengan format 'public/berkas_ppdb/namafile.jpg'
                // Storage::delete() membutuhkan path relatif dari 'storage/app'
                // Jadi kita perlu hapus 'public/' dari string
                $pathToDelete = str_replace('public/', '', $file->path_file);
                Storage::delete($pathToDelete);
            }

            DB::commit();
            return redirect()->route('ppdb.index')->with('success', 'Data pendaftar berhasil dihapus permanen.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->route('ppdb.index')
                ->with('error', 'Gagal menghapus data. Error: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan siswa yang SUDAH melengkapi berkas.
     * Logikanya: siswa yang memiliki record di tabel `berkas_pendaftaran`.
     */
    public function sudahBerkas()
    {
        $pendaftar = DB::table('calon_siswa')
            ->join('jalur_pendaftaran', 'calon_siswa.id_jalur_pendaftaran', '=', 'jalur_pendaftaran.id_jalur')
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))->from('berkas_pendaftaran')->whereColumn('berkas_pendaftaran.id_siswa', 'calon_siswa.id_siswa');
            })
            ->select('calon_siswa.*', 'jalur_pendaftaran.nama_jalur')
            ->orderBy('calon_siswa.id_siswa', 'desc')
            ->get();

        $data = [
            'title' => 'Pendaftar (Sudah Pemberkasan)',
            'pendaftar' => $pendaftar,
        ];
        return view('dashboard.ppdb.sudah_berkas', $data);
    }

    /**
     * Menampilkan siswa yang BELUM melengkapi berkas.
     * Logikanya: siswa yang TIDAK memiliki record di tabel `berkas_pendaftaran`.
     */
    public function belumBerkas()
    {
        $pendaftar = DB::table('calon_siswa')
            ->join('jalur_pendaftaran', 'calon_siswa.id_jalur_pendaftaran', '=', 'jalur_pendaftaran.id_jalur')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))->from('berkas_pendaftaran')->whereColumn('berkas_pendaftaran.id_siswa', 'calon_siswa.id_siswa');
            })
            ->select('calon_siswa.*', 'jalur_pendaftaran.nama_jalur')
            ->orderBy('calon_siswa.id_siswa', 'desc')
            ->get();

        $data = [
            'title' => 'Pendaftar (Belum Pemberkasan)',
            'pendaftar' => $pendaftar,
        ];
        return view('dashboard.ppdb.belum_berkas', $data);
    }
}
