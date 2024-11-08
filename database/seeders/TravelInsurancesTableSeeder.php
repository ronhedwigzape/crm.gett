<?php

namespace Database\Seeders;

use App\Models\TravelInsurance;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TravelInsurancesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TravelInsurance::factory(30)->create();
    }
}
