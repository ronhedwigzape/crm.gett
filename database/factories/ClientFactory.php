<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name'      => $this->faker->firstName,
            'middle_name'     => $this->faker->firstName,
            'last_name'       => $this->faker->lastName,
            'email'           => $this->faker->unique()->safeEmail,
            'phone'           => $this->faker->phoneNumber,
            'address'         => $this->faker->address,
            'date_of_birth'   => $this->faker->date(),
            'gender'          => $this->faker->randomElement(['Male', 'Female', 'Other']),
            'passport_number' => strtoupper($this->faker->bothify('??######')),
            'user_id'         => User::inRandomOrder()->first()->id,
        ];
    }
}
