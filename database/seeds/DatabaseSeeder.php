<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AdminsTableSeeder::class,
            PetugasHarianTableSeeder::class,
            TblSettingTableSeeder::class,
            KeuanganHeaderTableSeeder::class,
            KeuanganDetailTableSeeder::class,
        ]);
    }
}
