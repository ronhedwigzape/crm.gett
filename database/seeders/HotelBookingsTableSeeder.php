<?php

namespace Database\Seeders;

use App\Models\HotelBooking;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HotelBookingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HotelBooking::factory(30)->create();
    }
}
