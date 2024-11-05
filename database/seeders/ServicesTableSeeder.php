<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            'Flight Ticket',
            'Tour Package',
            'Hotel Booking',
            'Travel Insurance',
            'Tourist Visa',
            'Transport Services',
        ];

        foreach ($services as $serviceName) {
            Service::create([
                'name'        => $serviceName,
                'description' => 'Description for ' . $serviceName,
            ]);
        }
    }
}
