<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str; // Import Str facade untuk membuat slug

class PengumumanController extends Controller
{
    /**
     * Menampilkan daftar semua pengumuman.
     */
    public function index()
    {
        $pengumuman = DB::table('pengumuman')->orderBy('created_at', 'desc')->get();
        return view('dashboard.pengumuman.index', ['data' => $pengumuman]);
    }

    /**
     * Menampilkan form untuk membuat pengumuman baru.
     */
    public function create()
    {
        return view('dashboard.pengumuman.create');
    }

    /**
     * Menyimpan pengumuman baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:191|unique:pengumuman,name',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'content' => 'required|string',
        ]);

        // Membuat slug unik
        $slug = Str::slug($request->name, '-');

        // Mengunggah file foto
        $namaFile = time() . '_' . $request->foto->getClientOriginalName();
        $request->foto->move(public_path('img/pengumuman'), $namaFile);

        DB::table('pengumuman')->insert([
            'name' => $request->name,
            'slug' => $slug,
            'content' => $request->content,
            'foto' => $namaFile,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('pengumuman.index')->with('add_sukses', 'Pengumuman baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit pengumuman.
     */
    public function edit($id)
    {
        $pengumuman = DB::table('pengumuman')->find($id);
        
        if(!$pengumuman) {
            return redirect()->route('pengumuman.index')->with('error', 'Data pengumuman tidak ditemukan.');
        }

        return view('dashboard.pengumuman.edit', ['pengumuman' => $pengumuman]);
    }

    /**
     * Memperbarui data pengumuman di database.
     */
    public function update(Request $request, $id)
    {
        $pengumuman = DB::table('pengumuman')->find($id);
        if(!$pengumuman) {
            return redirect()->route('pengumuman.index')->with('error', 'Data pengumuman tidak ditemukan.');
        }

        $request->validate([
            // Pastikan validasi unik mengabaikan id saat ini
            'name' => 'required|string|max:191|unique:pengumuman,name,' . $id,
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'content' => 'required|string',
        ]);

        $slug = Str::slug($request->name, '-');

        $data = [
            'name' => $request->name,
            'slug' => $slug,
            'content' => $request->content,
            'updated_at' => now(),
        ];

        if ($request->hasFile('foto')) {
            // Hapus foto lama
            $pathFotoLama = public_path('img/pengumuman/' . $pengumuman->foto);
            if (File::exists($pathFotoLama)) {
                File::delete($pathFotoLama);
            }

            // Unggah foto baru
            $namaFileBaru = time() . '_' . $request->foto->getClientOriginalName();
            $request->foto->move(public_path('img/pengumuman'), $namaFileBaru);
            $data['foto'] = $namaFileBaru;
        }

        DB::table('pengumuman')->where('id', $id)->update($data);

        return redirect()->route('pengumuman.index')->with('edit_sukses', 'Pengumuman berhasil diperbarui.');
    }

    /**
     * Menghapus pengumuman dari database.
     */
    public function destroy($id)
    {
        $pengumuman = DB::table('pengumuman')->find($id);
        if(!$pengumuman) {
            return redirect()->route('pengumuman.index')->with('error', 'Data pengumuman tidak ditemukan.');
        }

        // Hapus foto dari folder public
        $pathFoto = public_path('img/pengumuman/' . $pengumuman->foto);
        if (File::exists($pathFoto)) {
            File::delete($pathFoto);
        }

        DB::table('pengumuman')->where('id', $id)->delete();

        return redirect()->route('pengumuman.index')->with('delete_sukses', 'Pengumuman berhasil dihapus.');
    }
}