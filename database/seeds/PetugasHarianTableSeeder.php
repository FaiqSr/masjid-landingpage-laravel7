<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PetugasHarianTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('petugas_harian')->insert([
            [
                'id' => 1,
                'waktu' => 'Subuh',
                'imam' => 'Ustadz Fathurrahman',
                'muadzin' => 'Agus Salim SA',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'waktu' => 'Dzuhur',
                'imam' => 'Ustadz Mahmudin',
                'muadzin' => 'Rahmat Hidayat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'waktu' => 'Ashar',
                'imam' => 'Ustadz Junaidi',
                'muadzin' => 'Faisal Amir',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'waktu' => 'Maghrib',
                'imam' => 'Ustadz Fathurrahman',
                'muadzin' => 'Agus Salim',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'waktu' => 'Isya',
                'imam' => 'Ustadz Mahmudin',
                'muadzin' => 'Rahmat Hidayat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
