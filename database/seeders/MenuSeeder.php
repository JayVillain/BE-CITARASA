<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        Menu::create([
            'name' => 'Nasi Goreng Spesial',
            'description' => 'Nasi goreng dengan telur, ayam, dan sayuran segar',
            'price' => 25000,
            'menu_category_id' => 1,
            'tag' => 'Populer'
        ]);

        Menu::create([
            'name' => 'Ayam Bakar Madu',
            'description' => 'Ayam bakar bumbu madu dan rempah',
            'price' => 35000,
            'menu_category_id' => 1,
        ]);

        Menu::create([
            'name' => 'Es Teh Manis',
            'description' => 'Minuman segar teh manis dingin',
            'price' => 5000,
            'menu_category_id' => 2,
        ]);
    }
}
