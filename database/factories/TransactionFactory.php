<?php

namespace Database\Factories;

use App\Models\FlightTicket;
use App\Models\HotelBooking;
use App\Models\Status;
use App\Models\TouristVisa;
use App\Models\TourPackage;
use App\Models\Transaction;
use App\Models\Client;
use App\Models\Service;
use App\Models\TransportService;
use App\Models\TravelInsurance;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $service = Service::inRandomOrder()->first();
        $client = Client::inRandomOrder()->first() ?? Client::factory()->create();
        $serviceDetail = $this->createServiceDetail($service, $client);

        return [
            'code' => $this->faker->uuid(),
            'client_id' => $client->id,
            'service_id' => $service->id,
            'status_id' => Status::inRandomOrder()->first()->id,
            'transaction_date' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'service_detail_type' => get_class($serviceDetail),
            'service_detail_id' => $serviceDetail->id,
            'total_amount' => $this->faker->randomFloat(2, 100, 5000),
            'user_id' => User::factory()->create()->id,
        ];
    }

    protected function createServiceDetail(Service $service, Client $client)
    {
        switch ($service->service_type) {
            case 'flight_ticket':
                return FlightTicket::factory()->create([
                    'service_id' => $service->id,
                ]);
            case 'tour_package':
                return TourPackage::factory()->create([
                    'service_id' => $service->id,
                ]);
            case 'hotel_booking':
                return HotelBooking::factory()->create([
                    'service_id' => $service->id,
                ]);
            case 'travel_insurance':
                return TravelInsurance::factory()->create([
                    'service_id' => $service->id,
                ]);
            case 'tourist_visa':
                return TouristVisa::factory()->create([
                    'service_id' => $service->id,
                ]);
            case 'transport_services':
                return TransportService::factory()->create([
                    'service_id' => $service->id,
                ]);
            default:
                throw new \Exception("Unknown service type: {$service->service_type}");
        }
    }
}
