<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class PengurusController extends Controller
{
    /**
     * Menampilkan daftar semua pengurus.
     */
    public function index()
    {
        $pengurus = DB::table('pengurus')->orderBy('id', 'asc')->get();
        return view('dashboard.pengurus.index', ['data' => $pengurus]);
    }

    /**
     * Menampilkan form untuk menambah pengurus baru.
     */
    public function create()
    {
        return view('dashboard.pengurus.create');
    }

    /**
     * Menyimpan data pengurus baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:150',
            'jabatan' => 'required|string|max:100',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $namaFile = time() . '_' . $request->foto->getClientOriginalName();
        // Pastikan folder public/img/pengurus sudah ada
        $request->foto->move(public_path('img/pengurus'), $namaFile);

        DB::table('pengurus')->insert([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'foto' => $namaFile,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('pengurus.index')->with('add_sukses', 'Data pengurus berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $pengurus = DB::table('pengurus')->find($id);

        if (!$pengurus) {
            return redirect()->route('pengurus.index')->with('error', 'Data pengurus tidak ditemukan.');
        }

        return view('dashboard.pengurus.edit', ['pengurus' => $pengurus]);
    }

    /**
     * Memperbarui data pengurus di database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:150',
            'jabatan' => 'required|string|max:100',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $pengurus = DB::table('pengurus')->find($id);
        if (!$pengurus) {
            return redirect()->route('pengurus.index')->with('error', 'Data pengurus tidak ditemukan.');
        }

        $data = [
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'updated_at' => now(),
        ];

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            $pathFotoLama = public_path('img/pengurus/' . $pengurus->foto);
            if (File::exists($pathFotoLama)) {
                File::delete($pathFotoLama);
            }

            // Unggah foto baru
            $namaFileBaru = time() . '_' . $request->foto->getClientOriginalName();
            $request->foto->move(public_path('img/pengurus'), $namaFileBaru);
            $data['foto'] = $namaFileBaru;
        }

        DB::table('pengurus')->where('id', $id)->update($data);

        return redirect()->route('pengurus.index')->with('edit_sukses', 'Data pengurus berhasil diperbarui.');
    }

    /**
     * Menghapus data pengurus dari database.
     */
    public function destroy($id)
    {
        $pengurus = DB::table('pengurus')->find($id);
        if (!$pengurus) {
            return redirect()->route('pengurus.index')->with('error', 'Data pengurus tidak ditemukan.');
        }

        // Hapus foto dari folder public
        $pathFoto = public_path('img/pengurus/' . $pengurus->foto);
        if (File::exists($pathFoto)) {
            File::delete($pathFoto);
        }

        DB::table('pengurus')->where('id', $id)->delete();

        return redirect()->route('pengurus.index')->with('delete_sukses', 'Data pengurus berhasil dihapus.');
    }
}
