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
            [
                'name' => 'Flight Ticket',
                'service_type' => 'flight_ticket',
                'description' => 'Description for Flight Ticket'
            ],
            [
                'name' => 'Tour Package',
                'service_type' => 'tour_package',
                'description' => 'Description for Tour Package'
            ],
            [
                'name' => 'Hotel Booking',
                'service_type' => 'hotel_booking',
                'description' => 'Description for Hotel Booking'
            ],
            [
                'name' => 'Travel Insurance',
                'service_type' => 'travel_insurance',
                'description' => 'Description for Travel Insurance'
            ],
            [
                'name' => 'Tourist Visa',
                'service_type' => 'tourist_visa',
                'description' => 'Description for Tourist Visa'
            ],
            [
                'name' => 'Transport Services',
                'service_type' => 'transport_services',
                'description' => 'Description for Transport Services'
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(['name' => $service['name']], $service);
        }
    }
}
