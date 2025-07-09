<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'id' => 1,
            'name' => 'admin',
            'email' => 'admin@localhost.com',
            'password' => '$2y$10$vIfeFoJAkJ8jSARMxYjN7.q006OGXZQEq91k7lEspGTnmdmqsnHfy',
            'id_role' => 1,
            'created_at' => '2025-04-27 14:50:00',
            'updated_at' => '2025-04-27 14:50:00',
        ]);
    }
}
