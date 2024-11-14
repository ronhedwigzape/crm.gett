<?php

namespace Database\Seeders;

use App\Models\Sale;
use App\Models\Transaction;
use Illuminate\Database\Seeder;

class TransactionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Transaction::factory()
            ->count(10)
            ->has(Sale::factory())
            ->create();
    }
}
