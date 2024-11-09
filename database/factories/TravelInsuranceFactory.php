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

        return [
            'service_id'         => Service::where('service_type', 'travel_insurance')->first()->id,
            'insurance_provider' => $this->faker->company,
            'policy_number'      => $this->faker->unique()->numerify('INS-######'),
            'start_date'         => $startDate,
            'end_date'           => $endDate,
            'fee'    => $this->faker->randomFloat(2, 1000, 10000),
        ];
    }
}
