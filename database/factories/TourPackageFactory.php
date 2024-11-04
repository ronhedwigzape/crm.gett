<?php

namespace Database\Factories;

use App\Models\TourPackage;
use App\Models\Client;
use App\Models\Service;
use App\Models\Status;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TourPackage>
 */
class TourPackageFactory extends Factory
{
    protected $model = TourPackage::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('+1 days', '+1 month');
        $endDate = (clone $startDate)->modify('+'. rand(3, 10) .' days');

        return [
            'client_id'     => Client::inRandomOrder()->first()->id,
            'service_id'    => Service::where('name', 'Tour Package')->first()->id,
            'status_id'     => Status::inRandomOrder()->first()->id,
            'package_name'  => $this->faker->sentence(3),
            'start_date'    => $startDate,
            'end_date'      => $endDate,
        ];
    }
}
