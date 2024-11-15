<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\FlightTicket;
use App\Models\TourPackage;
use App\Models\HotelBooking;
use App\Models\TravelInsurance;
use App\Models\TouristVisa;
use App\Models\TransportService;
use Illuminate\Database\Seeder;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $serviceDetails = [
            [
                'name' => 'Flight Ticket',
                'service_type' => 'flight_ticket',
                'description' => 'Description for Flight Ticket',
                'model' => FlightTicket::class,
            ],
            [
                'name' => 'Tour Package',
                'service_type' => 'tour_package',
                'description' => 'Description for Tour Package',
                'model' => TourPackage::class,
            ],
            [
                'name' => 'Hotel Booking',
                'service_type' => 'hotel_booking',
                'description' => 'Description for Hotel Booking',
                'model' => HotelBooking::class,
            ],
            [
                'name' => 'Travel Insurance',
                'service_type' => 'travel_insurance',
                'description' => 'Description for Travel Insurance',
                'model' => TravelInsurance::class,
            ],
            [
                'name' => 'Tourist Visa',
                'service_type' => 'tourist_visa',
                'description' => 'Description for Tourist Visa',
                'model' => TouristVisa::class,
            ],
            [
                'name' => 'Transport Services',
                'service_type' => 'transport_services',
                'description' => 'Description for Transport Services',
                'model' => TransportService::class,
            ],
        ];

        foreach ($serviceDetails as $detail) {
            // Create a service detail record
            $serviceDetail = $detail['model']::factory()->create();

            // Create or update the service record
            Service::updateOrCreate(
                ['name' => $detail['name']],
                [
                    'service_type' => $detail['service_type'],
                    'description' => $detail['description'],
                    'service_detail_type' => $detail['model'],
                    'service_detail_id' => $serviceDetail->id,
                ]
            );
        }
    }
}
