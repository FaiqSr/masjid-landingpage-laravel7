<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PetugasController extends Controller
{
    public function index()
    {
        $data = DB::table('petugas_harian')->get();

        return view('dashboard.petugas.index', compact('data'));
    }

    public function edit($id)
    {

        $data = DB::table('petugas_harian')->where('id', $id)->first();

        return view('dashboard.petugas.edit', compact('data'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'id' => 'required',
            'imam'    => 'string|nullable',
            'muadzin' => 'string|nullable'
        ]);

        DB::table('petugas_harian')
            ->where('id', $data['id'])
            ->update($data);

        return redirect()->route('petugas.index')->with('sukses', 'Data petugas berhasil diperbarui!');
    }
}
