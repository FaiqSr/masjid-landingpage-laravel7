<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PpdbController extends Controller
{
    public function create()
    {
        $jalur_pendaftaran = DB::table('jalur_pendaftaran')->get();
        return view('ppdb.register', ['jalur_pendaftaran' => $jalur_pendaftaran]);
    }

    public function store(Request $request)
    {
        $rules = [
            'email' => 'required|email|unique:akun_pendaftar,email',
            'password' => 'required|min:8|confirmed',
            'nama_lengkap' => 'required|string|max:255',
            'nisn' => 'required|numeric|digits:10|unique:calon_siswa,nisn',
            'nik' => 'required|numeric|digits:16|unique:calon_siswa,nik',
            'nokk' => 'required|numeric|digits:16|unique:calon_siswa,no_kk',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'anak_ke' => 'required|integer|min:1',
            'jumlah_saudara' => 'required|integer|min:0',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'agama' => 'required|string|max:50',
            'alamat_lengkap' => 'required|string',
            'sekolah_asal' => 'required|string|max:255',
            'tahun_lulus' => 'required|numeric|digits:4',
            'id_jalur_pendaftaran' => 'required|exists:jalur_pendaftaran,id_jalur',
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'no_telepon_ortu' => 'required|string|max:15',
            'file_kk' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'file_ijazah' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'pas_foto' => 'required|file|mimes:jpg,jpeg,png|max:1024',
            'persetujuan' => 'required|accepted',
        ];

        $messages = [
            'required' => 'Kolom :attribute wajib diisi.',
            'unique' => ':attribute ini sudah terdaftar.',
            'confirmed' => 'Konfirmasi password tidak cocok.',
            'mimes' => 'Berkas :attribute harus berformat :values.',
            'max.file' => 'Ukuran berkas :attribute tidak boleh lebih dari :max kilobyte.',
            'digits' => 'Kolom :attribute harus terdiri dari :digits digit.',
            'password.min' => 'Password minimal harus 8 karakter.',
            // BARU: Pesan error untuk validasi baru
            'anak_ke.integer' => 'Kolom anak ke harus berupa angka.',
            'anak_ke.min' => 'Kolom anak ke minimal harus 1.',
            'jumlah_saudara.integer' => 'Kolom jumlah saudara harus berupa angka.',
            'jumlah_saudara.min' => 'Kolom jumlah saudara minimal harus 0.',
            'id_jalur_pendaftaran.required' => 'Anda wajib memilih jalur pendaftaran.',
            'persetujuan.accepted' => 'Anda harus menyetujui pernyataan untuk melanjutkan.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->route('ppdb.register')->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
            $tahun_ajaran_aktif = DB::table('tahun_ajaran')->where('status', 'Aktif')->first();

            if (!$tahun_ajaran_aktif) {
                return redirect()->route('ppdb.register')->with('error', 'Pendaftaran untuk saat ini sedang ditutup.');
            }

            $akunId = DB::table('akun_pendaftar')->insertGetId([
                'email' => $request->input('email'),
                'password_hash' => Hash::make($request->input('password')),
                'status_akun' => 'Aktif',
                'tanggal_dibuat' => now(),
            ]);

            $nomorPendaftaran = 'PPDB-' . date('Ymd') . '-' . Str::upper(Str::random(4));

            $calonSiswaId = DB::table('calon_siswa')->insertGetId([
                'id_akun' => $akunId,
                'nomor_pendaftaran' => $nomorPendaftaran,
                'nama_lengkap' => $request->input('nama_lengkap'),
                'nisn' => $request->input('nisn'),
                'nik' => $request->input('nik'),
                'no_kk' => $request->input('nokk'),
                'tempat_lahir' => $request->input('tempat_lahir'),
                'tanggal_lahir' => $request->input('tanggal_lahir'),
                'jenis_kelamin' => $request->input('jenis_kelamin'),
                'agama' => $request->input('agama'),
                'alamat_lengkap' => $request->input('alamat_lengkap'),
                'anak_ke' => $request->input('anak_ke'),
                'jumlah_saudara' => $request->input('jumlah_saudara'),
                'sekolah_asal' => $request->input('sekolah_asal'),
                'tahun_lulus' => $request->input('tahun_lulus'),
                'id_jalur_pendaftaran' => $request->input('id_jalur_pendaftaran'),
                'status_pendaftaran' => 'Menunggu Verifikasi',
                'status_pemberkasan' => 'Sudah',
                'tanggal_registrasi' => now(),
                'id_jalur_pendaftaran' => $request->input('id_jalur_pendaftaran'),
                'id_tahun_ajaran' => $tahun_ajaran_aktif->id_tahun_ajaran,
                'status_pendaftaran' => 'Menunggu Verifikasi',
            ]);

            DB::table('orang_tua_wali')->insert([
                'id_siswa' => $calonSiswaId,
                'hubungan' => 'Ayah',
                'nama_lengkap' => $request->input('nama_ayah'),
                'pekerjaan' => $request->input('pekerjaan_ayah'),
                'no_telepon_ortu' => $request->input('no_telepon_ortu'),
            ]);
            DB::table('orang_tua_wali')->insert([
                'id_siswa' => $calonSiswaId,
                'hubungan' => 'Ibu',
                'nama_lengkap' => $request->input('nama_ibu'),
                'pekerjaan' => $request->input('pekerjaan_ibu'),
            ]);
            $berkasToSave = ['file_kk' => 'Kartu Keluarga', 'file_ijazah' => 'Ijazah', 'pas_foto' => 'Pas Foto'];
            foreach ($berkasToSave as $key => $jenis) {
                if ($request->hasFile($key)) {
                    try {
                        $file = $request->file($key);
                        $fileName = $request->input('nisn') . '_' . Str::slug($jenis) . '.' . $file->getClientOriginalExtension();

                        $destinationPath = public_path('berkas_ppdb');

                        $file->move($destinationPath, $fileName);

                        $pathForDb = 'berkas_ppdb/' . $fileName;

                        DB::table('berkas_pendaftaran')->insert([
                            'id_siswa' => $calonSiswaId,
                            'jenis_berkas' => $jenis,
                            'nama_file_asli' => $file->getClientOriginalName(),
                            'path_file' => $pathForDb, // <- Menggunakan path yang benar
                            'tanggal_upload' => now(),
                        ]);
                    } catch (\Exception $e) {
                        DB::rollBack();
                        return redirect()
                            ->route('ppdb.register')
                            ->with('error', 'Gagal mengunggah berkas: ' . $jenis . '. Pesan: ' . $e->getMessage())
                            ->withInput();
                    }
                }
            }
            DB::commit();
            return redirect()
                ->route('ppdb.success')
                ->with(['success' => 'Pendaftaran Anda berhasil!', 'nomor_pendaftaran' => $nomorPendaftaran, 'nama_siswa' => $request->input('nama_lengkap')]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->route('ppdb.register')
                ->with('error', 'Terjadi kesalahan fatal. Error: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function success()
    {
        if (session('success')) {
            return view('ppdb.success');
        }
        return redirect()->route('ppdb.register');
    }

    public function searchByNik(Request $request)
    {
        $request->validate([
            'nik' => 'required|numeric|digits:16',
        ]);

        $siswa = DB::table('calon_siswa')->where('nik', $request->nik)->first();

        if ($siswa) {
            return redirect()->route('ppdb.result.show', $siswa->id_siswa);
        } else {
            return redirect()->back()->with('error', 'Data pendaftaran dengan NIK tersebut tidak ditemukan.');
        }
    }

    public function showResult($id)
    {
        $siswa = DB::table('calon_siswa')->join('jalur_pendaftaran', 'calon_siswa.id_jalur_pendaftaran', '=', 'jalur_pendaftaran.id_jalur')->select('calon_siswa.*', 'jalur_pendaftaran.nama_jalur')->where('calon_siswa.id_siswa', $id)->first();

        if (!$siswa) {
            abort(404);
        }

        $data = [
            'title' => 'Hasil Pendaftaran - ' . $siswa->nama_lengkap,
            'siswa' => $siswa,
        ];

        return view('ppdb.result', $data);
    }
    public function downloadPdf($id)
    {
        $siswa = DB::table('calon_siswa')
            ->join('jalur_pendaftaran', 'calon_siswa.id_jalur_pendaftaran', '=', 'jalur_pendaftaran.id_jalur')
            ->join('tahun_ajaran', 'calon_siswa.id_tahun_ajaran', '=', 'tahun_ajaran.id_tahun_ajaran')
            ->select('calon_siswa.*', 'jalur_pendaftaran.nama_jalur', 'tahun_ajaran.tahun_ajaran')
            ->where('calon_siswa.id_siswa', $id)
            ->first();

        if (!$siswa) {
            abort(404);
        }

        $orang_tua = DB::table('orang_tua_wali')->where('id_siswa', $id)->get();

        $pas_foto = DB::table('berkas_pendaftaran')->where('id_siswa', $id)->where('jenis_berkas', 'Pas Foto')->first();

        $data = [
            'siswa' => $siswa,
            'orang_tua' => $orang_tua,
            'pas_foto' => $pas_foto, 
        ];

        $pdf = Pdf::loadView('ppdb.pdf_template', $data);

        $fileName = 'bukti-pendaftaran-' . Str::slug($siswa->nama_lengkap) . '.pdf';

        return $pdf->download($fileName);
    }
}
