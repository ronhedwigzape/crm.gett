<?php

namespace Database\Seeders;

use App\Models\Airline;
use App\Models\Client;
use App\Models\FlightTicket;
use App\Models\Service;
use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FlightTicketsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FlightTicket::factory(50)->create();
    }
}
