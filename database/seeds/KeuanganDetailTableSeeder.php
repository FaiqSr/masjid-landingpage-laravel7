<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KeuanganDetailTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('keuangan_detail')->insert([
            [
                'id' => 1,
                'header_id' => 1,
                'tanggal_transaksi' => '2025-07-10',
                'keterangan' => 'Infaq Kotak Amal Jumat',
                'tipe' => 'D',
                'nilai' => 1500000.00,
                'created_at' => '2025-07-09 18:07:38',
                'updated_at' => '2025-07-09 18:07:38',
            ],
            [
                'id' => 2,
                'header_id' => 1,
                'tanggal_transaksi' => '2025-07-10',
                'keterangan' => 'Pembayaran Listrik & Air',
                'tipe' => 'K',
                'nilai' => 300000.00,
                'created_at' => '2025-07-09 18:15:34',
                'updated_at' => '2025-07-09 18:15:34',
            ],
        ]);
    }
}
