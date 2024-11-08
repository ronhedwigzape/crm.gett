<?php

namespace Database\Factories;

use App\Models\FlightTicket;
use App\Models\Client;
use App\Models\Service;
use App\Models\Status;
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
        $arrivalDate = (clone $departureDate)->modify('+'. rand(1, 12) .' hours');

        return [
            'service_id'        => Service::where('name', 'Flight Ticket')->first()->id,
            'airline_id'        => Airline::inRandomOrder()->first()->id,
            'flight_number'     => strtoupper($this->faker->bothify('??###')),
            'departure_airport' => $this->faker->city,
            'arrival_airport'   => $this->faker->city,
            'departure_date'    => $departureDate,
            'fee'            => $this->faker->randomFloat(2, 100, 10000),
            'arrival_date'      => $arrivalDate,
            'seat_class'        => $this->faker->randomElement(['Economy', 'Business', 'First Class']),
        ];
    }
}
