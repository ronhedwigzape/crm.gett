<?php

namespace Database\Factories;

use App\Models\Sale;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
{
    protected $model = Sale::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $transaction = Transaction::factory()->create();

        return [
            'transaction_id' => $transaction->id,
            'amount' => $transaction->total_amount,
            'commission' => $transaction->total_amount * 0.1,
            'sale_date' => $transaction->transaction_date,
        ];
    }
}
