<?php

namespace Database\Factories;

use App\Models\Service;
use App\Models\TouristVisa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TouristVisa>
 */
class TouristVisaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $issueDate = $this->faker->dateTimeBetween('-1 year', 'now');
        $expiryDate = (clone $issueDate)->modify('+' . rand(1, 5) . ' years');

        // Attempt to find the 'Tourist Visa' service, or create it if it doesn't exist
        $service = Service::firstOrCreate(
            ['name' => 'Tourist Visa'],
            [
                'service_type' => 'tourist_visa',
                'description' => 'Description for Tourist Visa',
                'service_detail_type' => TouristVisa::class,
                'service_detail_id' => 0, // Placeholder, will be updated after creation
            ]
        );

        return [
            'service_id' => $service->id,
            'visa_type' => $this->faker->randomElement(['Single Entry', 'Multiple Entry']),
            'country' => $this->faker->country,
            'issue_date' => $issueDate,
            'expiry_date' => $expiryDate,
            'fee' => $this->faker->randomFloat(2, 50, 200),
        ];
    }
}
