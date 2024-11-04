<?php

namespace Database\Factories;

use App\Models\Status;
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
            'client_id'        => Client::inRandomOrder()->first()->id,
            'service_id'       => Service::inRandomOrder()->first()->id,
            'status_id'        => Status::inRandomOrder()->first()->id,
            'transaction_date' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
