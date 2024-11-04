<?php

namespace Database\Seeders;

use App\Models\FlightTicket;
use Illuminate\Database\Seeder;

class FlightTicketsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FlightTicket::factory(30)->create();
    }
}
