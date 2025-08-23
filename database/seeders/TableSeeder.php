<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Table;

class TableSeeder extends Seeder
{
    public function run(): void
    {
        Table::create(['number' => '01', 'capacity' => 4, 'status' => 'available']);
        Table::create(['number' => '02', 'capacity' => 2, 'status' => 'available']);
        Table::create(['number' => '03', 'capacity' => 6, 'status' => 'available']);
    }
}
