<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FunkosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('funkos')->insert([
            ['name' => 'Superheros', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Movies', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'TV Series', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Videogames', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Animals', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
