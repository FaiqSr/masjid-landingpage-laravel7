<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KeuanganController extends Controller
{
    // Menampilkan daftar Laporan Keuangan (Header)
    public function index()
    {
        $laporan = DB::table('keuangan_header')->orderBy('periode', 'desc')->get();
        return view('dashboard.keuangan.index', ['laporan' => $laporan]);
    }

    // Menampilkan form untuk membuat Laporan Keuangan baru
    public function create()
    {
        return view('dashboard.keuangan.create');
    }

    // Menyimpan Laporan Keuangan baru
    public function store(Request $request)
    {
        $request->validate([
            'periode' => 'required|date',
            'akun' => 'required|string|max:191',
            'saldo_awal' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:191',
        ]);

        DB::table('keuangan_header')->insert([
            'periode' => $request->periode,
            'akun' => $request->akun,
            'keterangan' => $request->keterangan,
            'saldo_awal' => $request->saldo_awal,
            'saldo_akhir' => $request->saldo_awal, // Saldo akhir awalnya sama dengan saldo awal
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('keuangan.index')->with('sukses', 'Laporan keuangan baru berhasil dibuat.');
    }

    // Menampilkan halaman detail untuk mengelola transaksi
    public function show($id)
    {
        $header = DB::table('keuangan_header')->find($id);
        if (!$header) {
            return redirect()->route('keuangan.index')->with('error', 'Laporan tidak ditemukan.');
        }

        $detail = DB::table('keuangan_detail')->where('header_id', $id)->orderBy('tanggal_transaksi', 'asc')->get();

        return view('dashboard.keuangan.show', compact('header', 'detail'));
    }

    // Menyimpan transaksi detail baru
    public function storeDetail(Request $request, $header_id)
    {
        $request->validate([
            'tanggal_transaksi' => 'required|date',
            'keterangan' => 'required|string|max:191',
            'tipe' => 'required|in:D,K',
            'nilai' => 'required|numeric|min:1',
        ]);

        DB::table('keuangan_detail')->insert([
            'header_id' => $header_id,
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'keterangan' => $request->keterangan,
            'tipe' => $request->tipe,
            'nilai' => $request->nilai,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Update kalkulasi pada header
        $this->recalculateHeader($header_id);

        return redirect()->route('keuangan.show', $header_id)->with('sukses', 'Transaksi berhasil ditambahkan.');
    }

    // Menghapus transaksi detail
    public function destroyDetail($id)
    {
        $detail = DB::table('keuangan_detail')->find($id);
        if (!$detail) {
            return back()->with('error', 'Transaksi tidak ditemukan.');
        }

        $header_id = $detail->header_id;
        DB::table('keuangan_detail')->where('id', $id)->delete();

        // Update kalkulasi pada header
        $this->recalculateHeader($header_id);

        return redirect()->route('keuangan.show', $header_id)->with('sukses', 'Transaksi berhasil dihapus.');
    }

    // Menghapus laporan keuangan header
    public function destroy($id)
    {
        // On DELETE CASCADE di database akan otomatis menghapus detailnya
        DB::table('keuangan_header')->where('id', $id)->delete();
        return redirect()->route('keuangan.index')->with('sukses', 'Laporan beserta seluruh transaksinya berhasil dihapus.');
    }

    // Fungsi private untuk menghitung ulang total pada header
    private function recalculateHeader($header_id)
    {
        $header = DB::table('keuangan_header')->find($header_id);

        $total_debet = DB::table('keuangan_detail')
            ->where('header_id', $header_id)
            ->where('tipe', 'D')
            ->sum('nilai');

        $total_kredit = DB::table('keuangan_detail')
            ->where('header_id', $header_id)
            ->where('tipe', 'K')
            ->sum('nilai');

        $saldo_akhir = $header->saldo_awal + $total_debet - $total_kredit;

        DB::table('keuangan_header')->where('id', $header_id)->update([
            'total_debet' => $total_debet,
            'total_kredit' => $total_kredit,
            'saldo_akhir' => $saldo_akhir,
            'updated_at' => now(),
        ]);
    }
}
