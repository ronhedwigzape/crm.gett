<?php

namespace Database\Seeders;

use App\Models\TouristVisa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TouristVisasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TouristVisa::factory(30)->create();
    }
}
