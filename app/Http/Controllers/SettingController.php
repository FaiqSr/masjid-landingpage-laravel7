<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{
    /**
     * Menampilkan form untuk mengedit pengaturan website.
     * Mengambil baris pertama dari tbl_setting.
     */
    public function edit()
    {
        $settings = DB::table('tbl_setting')->where('id', 1)->first();

        // Jika tabel kosong, siapkan objek default agar tidak error di view
        if (!$settings) {
            $settings = (object) [
                'nama' => '',
                'alamat' => '',
                'wa' => '',
                'ig' => '',
                'fb' => '',
                'foto' => null,
                'logo' => null,
                'icon' => null,
                'kota_untuk_sholat' => 'Jakarta',
                'running_text' => '',
                'visi_misi' => '',
                'tentang_kami' => '',
            ];
        }

        return view('dashboard.setting.edit', ['settings' => $settings]);
    }

    /**
     * Memperbarui data pengaturan di database.
     */
    public function update(Request $request)
    { // Validasi semua input termasuk yang baru
        $request->validate([
            'nama' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'wa' => 'nullable|string|max:50',
            'ig' => 'nullable|string|max:50',
            'fb' => 'nullable|string|max:50',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg,svg|max:1024',
            'icon' => 'nullable|image|mimes:png,ico|max:512',
            'kota_untuk_sholat' => 'nullable|string|max:100',
            'running_text' => 'nullable|string',
            'visi_misi' => 'nullable|string',
            'tentang_kami' => 'nullable|string',
        ]);

        // Ambil data teks dari request
        $data = $request->only([
            'nama',
            'alamat',
            'wa',
            'ig',
            'fb',
            'kota_untuk_sholat',
            'running_text',
            'visi_misi',
            'tentang_kami'
        ]);

        $currentSettings = DB::table('tbl_setting')->where('id', 1)->first();

        // Helper untuk menangani unggahan file
        $handleUpload = function ($fileInputName, $directory) use ($request, $currentSettings, &$data) {
            if ($request->hasFile($fileInputName)) {
                // Hapus file lama jika ada
                if ($currentSettings && !empty($currentSettings->$fileInputName)) {
                    File::delete(public_path($directory . '/' . $currentSettings->$fileInputName));
                }
                // Unggah file baru
                $file = $request->file($fileInputName);
                $fileName = $fileInputName . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path($directory), $fileName);
                $data[$fileInputName] = $fileName;
            }
        };

        // Proses unggahan untuk setiap file
        $handleUpload('foto', 'img/settings');
        $handleUpload('logo', 'img/settings');
        $handleUpload('icon', 'img/settings');

        // Gunakan updateOrInsert untuk membuat atau memperbarui data
        DB::table('tbl_setting')->updateOrInsert(['id' => 1], $data);

        return redirect()->route('setting.edit')->with('sukses', 'Pengaturan berhasil diperbarui!');
    }
}
