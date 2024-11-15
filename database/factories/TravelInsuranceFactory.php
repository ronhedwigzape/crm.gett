<?php

namespace Database\Factories;

use App\Models\Service;
use App\Models\TravelInsurance;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TravelInsurance>
 */
class TravelInsuranceFactory extends Factory
{
    protected $model = TravelInsurance::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('+1 days', '+1 month');
        $endDate = (clone $startDate)->modify('+' . rand(1, 12) . ' months');

        // Attempt to find the 'Travel Insurance' service, or create it if it doesn't exist
        $service = Service::firstOrCreate(
            ['name' => 'Travel Insurance'],
            [
                'service_type' => 'travel_insurance',
                'description' => 'Description for Travel Insurance',
                'service_detail_type' => TravelInsurance::class,
                'service_detail_id' => 0, // Placeholder, will be updated after creation
            ]
        );

        return [
            'service_id' => $service->id,
            'insurance_provider' => $this->faker->company,
            'policy_number' => $this->faker->unique()->numerify('INS-######'),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'fee' => $this->faker->randomFloat(2, 1000, 10000),
        ];
    }
}
