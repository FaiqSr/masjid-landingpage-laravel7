<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KeuanganHeaderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('keuangan_header')->insert([
            'id' => 1,
            'periode' => '2025-07-01',
            'akun' => 'Kas Masjid',
            'keterangan' => 'Laporan Bulanan',
            'saldo_awal' => 15000000.00,
            'total_debet' => 1500000.00,
            'total_kredit' => 300000.00,
            'saldo_akhir' => 16200000.00,
            'created_at' => '2025-07-09 18:06:47',
            'updated_at' => '2025-07-09 18:15:34',
        ]);
    }
}
