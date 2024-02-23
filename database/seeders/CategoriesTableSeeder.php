<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['id' => 'c5944365-d957-4221-a743-778c507a5397', 'name' => 'Superheros', 'created_at' => now(), 'updated_at' => now()],
            ['id' => Str::uuid(), 'name' => 'Movies', 'created_at' => now(), 'updated_at' => now()],
            ['id' => Str::uuid(), 'name' => 'TV Series', 'created_at' => now(), 'updated_at' => now()],
            ['id' => Str::uuid(), 'name' => 'Videogames', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
