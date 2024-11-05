<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            ['name' => 'Flight Ticket', 'description' => 'Description for Flight Ticket'],
            ['name' => 'Tour Package', 'description' => 'Description for Tour Package'],
            ['name' => 'Hotel Booking', 'description' => 'Description for Hotel Booking'],
            ['name' => 'Travel Insurance', 'description' => 'Description for Travel Insurance'],
            ['name' => 'Tourist Visa', 'description' => 'Description for Tourist Visa'],
            ['name' => 'Transport Services', 'description' => 'Description for Transport Services'],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(['name' => $service['name']], $service);
        }
    }
}
