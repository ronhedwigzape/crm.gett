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

        // Attempt to find the 'Transport Services' service, or create it if it doesn't exist
        $service = Service::firstOrCreate(
            ['name' => 'Transport Services'],
            [
                'service_type' => 'transport_services',
                'description' => 'Description for Transport Services',
                'service_detail_type' => TransportService::class,
                'service_detail_id' => 0, // Placeholder, will be updated after creation
            ]
        );

        return [
            'service_id' => $service->id,
            'transport_type' => $this->faker->randomElement(['Car', 'Bus', 'Train', 'Flight']),
            'pickup_location' => $this->faker->address,
            'dropoff_location' => $this->faker->address,
            'pickup_datetime' => $pickupDateTime,
            'fee' => $this->faker->randomFloat(2, 20, 500),
        ];
    }
}
