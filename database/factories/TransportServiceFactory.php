<?php

namespace Database\Factories;

use App\Models\Service;
use App\Models\TransportService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TransportService>
 */
class TransportServiceFactory extends Factory
{
    protected $model = TransportService::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $pickupDateTime = $this->faker->dateTimeBetween('+1 days', '+1 month');

        return [
            'service_id'       => Service::where('service_type', 'transport_services')->first()->id,
            'transport_type'   => $this->faker->randomElement(['Car', 'Bus', 'Train', 'Flight']),
            'pickup_location'  => $this->faker->address,
            'dropoff_location' => $this->faker->address,
            'pickup_datetime'  => $pickupDateTime,
            'fee'      => $this->faker->randomFloat(2, 20, 500),
        ];
    }
}
