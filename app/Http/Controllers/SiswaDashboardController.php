<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class SiswaDashboardController extends Controller
{
    public function index()
    {
        $id_siswa = session('id_siswa');

        $siswa = DB::table('calon_siswa')->join('tahun_ajaran', 'calon_siswa.id_tahun_ajaran', '=', 'tahun_ajaran.id_tahun_ajaran')->join('jalur_pendaftaran', 'calon_siswa.id_jalur_pendaftaran', '=', 'jalur_pendaftaran.id_jalur')->select('calon_siswa.*', 'tahun_ajaran.tahun_ajaran', 'jalur_pendaftaran.nama_jalur')->where('calon_siswa.id_siswa', $id_siswa)->first();

        return view('siswaDashboard.index', [
            'title' => 'Dashboard Siswa',
            'siswa' => $siswa,
        ]);
    }
    
    public function showData()
    {
        $id_siswa = session('id_siswa');

        $siswa = DB::table('calon_siswa')->join('jalur_pendaftaran', 'calon_siswa.id_jalur_pendaftaran', '=', 'jalur_pendaftaran.id_jalur')->join('akun_pendaftar', 'calon_siswa.id_akun', '=', 'akun_pendaftar.id_akun')->select('calon_siswa.*', 'jalur_pendaftaran.nama_jalur', 'akun_pendaftar.email')->where('calon_siswa.id_siswa', $id_siswa)->first();

        if (!$siswa) {
            return redirect()->route('siswa.dashboard')->with('gagal', 'Data pendaftaran tidak ditemukan.');
        }

        $orang_tua = DB::table('orang_tua_wali')->where('id_siswa', $id_siswa)->get();
        $berkas = DB::table('berkas_pendaftaran')->where('id_siswa', $id_siswa)->get();

        $data = [
            'title' => 'Data Pendaftaran Saya',
            'siswa' => $siswa,
            'orang_tua' => $orang_tua,
            'berkas' => $berkas,
        ];

        return view('siswaDashboard.data.show', $data);
    }

    /**
     * Menampilkan form untuk mengubah data diri siswa.
     */
    public function edit()
    {
        $id_siswa = session('id_siswa');
        $siswa = DB::table('calon_siswa')->where('id_siswa', $id_siswa)->first();

        if (!$siswa) {
            return redirect()->route('siswa.dashboard')->with('gagal', 'Data pendaftaran tidak ditemukan.');
        }

        // Redirect jika status sudah tidak memungkinkan untuk edit
        if ($siswa->status_pendaftaran !== 'Menunggu Verifikasi') {
            return redirect()->route('dashboard.siswa.show')->with('gagal', 'Data tidak dapat diubah lagi karena sudah diproses oleh panitia.');
        }

        $orang_tua = DB::table('orang_tua_wali')->where('id_siswa', $id_siswa)->get();
        $data_ortu = [];
        foreach ($orang_tua as $ortu) {
            $data_ortu[$ortu->hubungan] = $ortu;
        }

        $semua_berkas = DB::table('berkas_pendaftaran')->where('id_siswa', $id_siswa)->get()->keyBy('jenis_berkas');

        $berkas = [
            'Kartu Keluarga' => $semua_berkas->get('Kartu Keluarga'),
            'Ijazah' => $semua_berkas->get('Ijazah'),
            'Pas Foto' => $semua_berkas->get('Pas Foto'),
        ];

        return view('siswaDashboard.data.edit', [
            'title' => 'Ubah Data Pendaftaran',
            'siswa' => $siswa,
            'data_ortu' => $data_ortu,
            'berkas' => $berkas,
        ]);
    }

    /**
     * Memproses pembaruan data dari form edit.
     */
    public function update(Request $request)
    {
        $id_siswa = session('id_siswa');

        $siswa_check = DB::table('calon_siswa')->where('id_siswa', $id_siswa)->first();
        if ($siswa_check->status_pendaftaran !== 'Menunggu Verifikasi') {
            return redirect()->route('dashboard.siswa.edit')->with('gagal', 'Aksi tidak diizinkan. Data sudah dikunci oleh panitia.');
        }

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'no_kk' => 'required|numeric|digits:16|unique:calon_siswa,no_kk,' . $id_siswa . ',id_siswa',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'alamat_lengkap' => 'required|string',
            'sekolah_asal' => 'required|string|max:191',
            'tahun_lulus' => 'required|numeric|digits:4',
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'no_telepon_ortu' => 'required|string|max:15',
            'pas_foto' => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
            'file_kk' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_ijazah' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        DB::beginTransaction();
        try {
            DB::table('calon_siswa')
                ->where('id_siswa', $id_siswa)
                ->update([
                    'nama_lengkap' => $request->nama_lengkap,
                    'no_kk' => $request->no_kk,
                    'tempat_lahir' => $request->tempat_lahir,
                    'tanggal_lahir' => $request->tanggal_lahir,
                    'alamat_lengkap' => $request->alamat_lengkap,
                    'anak_ke' => $request->anak_ke,
                    'jumlah_saudara' => $request->jumlah_saudara,
                    'sekolah_asal' => $request->sekolah_asal,
                    'tahun_lulus' => $request->tahun_lulus,
                ]);

            DB::table('orang_tua_wali')
                ->where('id_siswa', $id_siswa)
                ->where('hubungan', 'Ayah')
                ->update([
                    'nama_lengkap' => $request->nama_ayah,
                    'pekerjaan' => $request->pekerjaan_ayah,
                    'no_telepon_ortu' => $request->no_telepon_ortu,
                ]);
            DB::table('orang_tua_wali')
                ->where('id_siswa', $id_siswa)
                ->where('hubungan', 'Ibu')
                ->update([
                    'nama_lengkap' => $request->nama_ibu,
                    'pekerjaan' => $request->pekerjaan_ibu,
                ]);

            $berkasToProcess = [
                'pas_foto' => 'Pas Foto',
                'file_kk' => 'Kartu Keluarga',
                'file_ijazah' => 'Ijazah',
            ];

            $nisn = DB::table('calon_siswa')->where('id_siswa', $id_siswa)->value('nisn');

            foreach ($berkasToProcess as $inputName => $jenisBerkas) {
                if ($request->hasFile($inputName)) {
                    $file = $request->file($inputName);
                    $fileName = $nisn . '_' . Str::slug($jenisBerkas) . '.' . $file->getClientOriginalExtension();
                    $destinationPath = public_path('berkas_ppdb');

                    if (!is_dir($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }

                    $berkas_lama = DB::table('berkas_pendaftaran')->where('id_siswa', $id_siswa)->where('jenis_berkas', $jenisBerkas)->first();

                    $file->move($destinationPath, $fileName);

                    $pathForDb = 'berkas_ppdb/' . $fileName;

                    DB::table('berkas_pendaftaran')->updateOrInsert(['id_siswa' => $id_siswa, 'jenis_berkas' => $jenisBerkas], ['nama_file_asli' => $file->getClientOriginalName(), 'path_file' => $pathForDb, 'status_verifikasi' => 'Menunggu Verifikasi', 'tanggal_upload' => now()]);

                    if ($berkas_lama && file_exists(public_path($berkas_lama->path_file))) {
                        if (public_path($berkas_lama->path_file) !== public_path($pathForDb)) {
                            unlink(public_path($berkas_lama->path_file));
                        }
                    }
                }
            }

            DB::commit();

            session(['nama_siswa' => $request->nama_lengkap]);
            return redirect()->route('dashboard.siswa.edit')->with('sukses', 'Data Anda berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->route('dashboard.siswa.edit')
                ->with('gagal', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
