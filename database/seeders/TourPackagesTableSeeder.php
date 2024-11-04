<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Service;
use App\Models\Status;
use App\Models\TourPackage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TourPackagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TourPackage::factory(30)->create();
    }
}
