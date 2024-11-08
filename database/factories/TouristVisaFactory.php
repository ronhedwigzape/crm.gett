<?php

namespace Database\Factories;

use App\Models\Service;
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

        return [
            'service_id'  => Service::where('service_type', 'tourist_visa')->first()->id,
            'visa_type'   => $this->faker->randomElement(['Single Entry', 'Multiple Entry']),
            'country'     => $this->faker->country,
            'issue_date'  => $issueDate,
            'expiry_date' => $expiryDate,
            'visa_fee'    => $this->faker->randomFloat(2, 50, 200),
        ];
    }
}
