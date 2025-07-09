<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; 

class LayananController extends Controller
{
    public function index()
    {
        $layanan = DB::table('layanan')->orderBy('id', 'desc')->get();
        return view('dashboard.layanan.index', ['data' => $layanan]);
    }

    /**
     * Menampilkan form untuk menambah layanan baru.
     */
    public function create()
    {
        return view('dashboard.layanan.create');
    }

    /**
     * Menyimpan layanan baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $namaFile = time() . '_' . $request->foto->getClientOriginalName();
        $request->foto->move(public_path('img/layanan'), $namaFile);

        DB::table('layanan')->insert([
            'nama' => $request->nama,
            'foto' => $namaFile,
        ]);

        return redirect('dashboard/layanan')->with('add_sukses', 'Data layanan berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit layanan.
     */
    public function edit($id)
    {
        $layanan = DB::table('layanan')->find($id);
        
        if(!$layanan) {
            return redirect('dashboard/layanan')->with('error', 'Data layanan tidak ditemukan.');
        }

        return view('dashboard.layanan.edit', ['layanan' => $layanan]);
    }

    /**
     * Memperbarui data layanan di database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $layanan = DB::table('layanan')->find($id);
        if(!$layanan) {
            return redirect('dashboard/layanan')->with('error', 'Data layanan tidak ditemukan.');
        }

        $data = ['nama' => $request->nama];

        if ($request->hasFile('foto')) {
            // Hapus foto lama
            $pathFotoLama = public_path('img/layanan/' . $layanan->foto);
            if (File::exists($pathFotoLama)) {
                File::delete($pathFotoLama);
            }

            // Unggah foto baru
            $namaFileBaru = time() . '_' . $request->foto->getClientOriginalName();
            $request->foto->move(public_path('img/layanan'), $namaFileBaru);
            $data['foto'] = $namaFileBaru;
        }

        DB::table('layanan')->where('id', $id)->update($data);

        return redirect('dashboard/layanan')->with('edit_sukses', 'Data layanan berhasil diperbarui.');
    }

    /**
     * Menghapus data layanan dari database.
     */
    public function destroy($id)
    {
        $layanan = DB::table('layanan')->find($id);
        if(!$layanan) {
            return redirect('dashboard/layanan')->with('error', 'Data layanan tidak ditemukan.');
        }

        // Hapus foto terkait
        $pathFoto = public_path('img/layanan/' . $layanan->foto);
        if (File::exists($pathFoto)) {
            File::delete($pathFoto);
        }

        DB::table('layanan')->where('id', $id)->delete();

        return redirect('dashboard/layanan')->with('delete_sukses', 'Data layanan berhasil dihapus.');
    }
}