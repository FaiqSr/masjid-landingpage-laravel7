<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GaleryController extends Controller
{
    public function index()
    {
        $data = DB::table('galery')->get();


        return view('dashboard.galery.index', compact('data'));
    }

    public function add()
    {
        return view('dashboard.galery.add');
    }

    public function create(Request $req)
    {
        // Validasi
        $req->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'detail' => 'required|string|max:255',
        ]);

        // Simpan ke public/image/galery
        $image = $req->file('image');
        $filename = time() . '_' . $image->getClientOriginalName();

        // Pindahkan file ke public/image/galery
        $image->move(public_path('image/galery'), $filename);

        // Simpan data ke database
        DB::table('galery')->insert([
            'url' => $filename,
            'detail' => $req->detail,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('dashboard/galery/index')->with('success', 'Foto berhasil diunggah!');
    }

    public function edit($id)
    {
        $item = DB::table('galery')->where('id', $id)->first();

        return view('dashboard.galery.edit', compact('item'));
    }

    public function update(Request $req)
    {
        $req->validate([
            'id' => 'required|exists:galery,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'detail' => 'required|string|max:255',
        ]);

        $row = DB::table('galery')->where('id', $req->id)->first();

        $filename = $row->url;

        if ($req->hasFile('image')) {
            $image = $req->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('image/galery'), $filename);

            if (file_exists(public_path('image/galery/' . $row->url))) {
                unlink(public_path('image/galery/' . $row->url));
            }
        }

        DB::table('galery')->where('id', $req->id)->update([
            'url' => $filename,
            'detail' => $req->detail,
            'updated_at' => now(),
        ]);

        return redirect()->route('dashboard/galery/index')->with('success', 'Data galeri berhasil diperbarui!');
    }

    public function delete($id)
    {
        $row = DB::table('galery')->where('id', $id)->first();

        if ($row) {
            DB::table('galery')->where('id', $id)->delete();
            unlink(public_path('image/galery/' . $row->url));
            return redirect()->back()->with('success', 'Foto berhasil dihapus!');
        }
        return redirect()->back()->with('error', 'Foto gagal dihapus!');
    }
}
