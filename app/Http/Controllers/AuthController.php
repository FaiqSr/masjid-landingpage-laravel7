<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $admin = DB::table('admins')->where('email', $request->email)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            session([
                'berhasil_login' => true,
                'id_user' => $admin->id,
                'nama_user' => $admin->name,
                'id_role' => $admin->id_role,
            ]);

            return redirect('dashboard');
        }

        return redirect()->route('login_page')->with('gagal', 'Email atau Password Admin salah.');
    }

    /**
     * Menangani proses login untuk SISWA/PENDAFTAR.
     * Menggunakan tabel 'akun_pendaftar'.
     */
    public function siswaLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $akun = DB::table('akun_pendaftar')->where('email', $request->email)->first();

        // Cek jika akun pendaftar ditemukan dan password cocok
        if ($akun && Hash::check($request->password, $akun->password_hash)) {
            // Ambil data siswa terkait untuk disimpan di session
            $siswa = DB::table('calon_siswa')->where('id_akun', $akun->id_akun)->first();

            // Jika data siswa tidak ada, jangan biarkan login
            if (!$siswa) {
                return redirect()->route('login_page')->with('gagal', 'Akun siswa tidak terhubung dengan data pendaftaran.');
            }

            session([
                'siswa_login' => true,
                'id_akun' => $akun->id_akun,
                'id_siswa' => $siswa->id_siswa,
                'nama_siswa' => $siswa->nama_lengkap,
                'email_siswa' => $akun->email,
            ]);

            return redirect()->route('dashboard.siswa.index');
        }

        return redirect()->route('login_page')->with('gagal', 'Email atau Password Siswa salah.');
    }

    public function logout()
    {
        session()->flush(); // Membersihkan semua data session
        return redirect('/')->with('sukses', 'Anda berhasil logout.');
    }
}
