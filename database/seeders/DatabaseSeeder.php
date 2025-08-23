<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            MenuCategorySeeder::class,
            MenuSeeder::class,
            TableSeeder::class,
            // UserSeeder::class,   // opsional kalau mau tambah user dummy
            // OrderSeeder::class,  // opsional kalau mau tambah order dummy
        ]);
    }
}
