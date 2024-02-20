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
            [
                'name' => 'Funko Batman',
                'image' => 'images/batman.png',
                'description' => 'Funko Batman Description',
                'price' => 10.99,
                'stock' => 5,
                'category_id' => 1,
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Funko Iron Man',
                'image' => 'images/ironman.png',
                'description' => 'Funko Iron Man Description',
                'price' => 19.99,
                'stock' => 10,
                'category_id' => 2,
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Funko Spider-Man',
                'image' => 'images/spiderman.png',
                'description' => 'Funko Spider-Man Description',
                'price' => 15.99,
                'stock' => 2,
                'category_id' => 1,
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Funko Darth Vader',
                'image' => 'images/darthvader.png',
                'description' => 'Funko Darth Vader Description',
                'price' => 25.99,
                'stock' => 8,
                'category_id' => 2,
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Funko Harry Potter',
                'image' => 'images/harry.png',
                'description' => 'Funko Harry Potter Description',
                'price' => 12.99,
                'stock' => 3,
                'category_id' => 2,
                'active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
