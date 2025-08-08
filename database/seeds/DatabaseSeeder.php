<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tahun_ajaran')->insert([['tahun_ajaran' => '2024/2025', 'status' => 'Tidak Aktif', 'created_at' => now(), 'updated_at' => now()], ['tahun_ajaran' => '2025/2026', 'status' => 'Aktif', 'created_at' => now(), 'updated_at' => now()]]);
    }
}
