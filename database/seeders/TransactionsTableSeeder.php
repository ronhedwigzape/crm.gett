<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Service;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransactionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = Client::all();
        $services = Service::all();
        $users = User::all();

        Transaction::factory(100)->make()->each(function ($transaction) use ($clients, $services, $users) {
            $transaction->client_id = $clients->random()->id;
            $transaction->service_id = $services->random()->id;
            $transaction->user_id = $users->random()->id;
            $transaction->save();
        });
    }
}
