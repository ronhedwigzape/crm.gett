<?php

namespace Database\Factories;

use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Report>
 */
class ReportFactory extends Factory
{
    protected $model = Report::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::inRandomOrder()->first() ?? User::factory()->create();

        return [
            'name' => $this->faker->sentence(),
            'type' => $this->faker->randomElement(['sales', 'transaction']),
            'generated_by' => $user->id,
            'generated_at' => now(),
            'data' => json_encode([
                'total_sales' => $this->faker->randomFloat(2, 1000, 100000),
                'total_transactions' => $this->faker->numberBetween(10, 500),
            ]),
        ];
    }
}
