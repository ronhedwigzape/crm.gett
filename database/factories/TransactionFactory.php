<?php

namespace Database\Factories;

use App\Models\Transaction;
use App\Models\Client;
use App\Models\Service;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id'        => Client::factory(),
            'service_id'       => Service::factory(),
            'transaction_date' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'amount'           => $this->faker->randomFloat(2, 100, 10000),
            'user_id'          => User::factory(),
        ];
    }
}
