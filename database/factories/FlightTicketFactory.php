<?php

namespace Database\Factories;

use App\Models\FlightTicket;
use App\Models\Service;
use App\Models\Airline;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FlightTicket>
 */
class FlightTicketFactory extends Factory
{
    protected $model = FlightTicket::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $departureDate = $this->faker->dateTimeBetween('+1 days', '+1 month');
        $arrivalDate = (clone $departureDate)->modify('+' . rand(1, 12) . ' hours');

        // Attempt to find the 'Flight Ticket' service, or create it if it doesn't exist
        $service = Service::firstOrCreate(
            ['name' => 'Flight Ticket'],
            [
                'service_type' => 'flight_ticket',
                'description' => 'Description for Flight Ticket',
                'service_detail_type' => FlightTicket::class,
                'service_detail_id' => 0, // Placeholder, will be updated after creation
            ]
        );

        return [
            'service_id' => $service->id,
            'airline_id' => Airline::inRandomOrder()->first()->id,
            'flight_number' => strtoupper($this->faker->bothify('??###')),
            'departure_airport' => $this->faker->city,
            'arrival_airport' => $this->faker->city,
            'departure_date' => $departureDate,
            'arrival_date' => $arrivalDate,
            'seat_class' => $this->faker->randomElement(['Economy', 'Business', 'First Class']),
            'fee' => $this->faker->randomFloat(2, 100, 10000),
        ];
    }
}
