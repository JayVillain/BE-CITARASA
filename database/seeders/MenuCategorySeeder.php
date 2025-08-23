<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuCategory;

class MenuCategorySeeder extends Seeder
{
    public function run(): void
    {
        MenuCategory::create(['name' => 'Makanan']);
        MenuCategory::create(['name' => 'Minuman']);
        MenuCategory::create(['name' => 'Dessert']);
    }
}
