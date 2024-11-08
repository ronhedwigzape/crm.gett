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
        return [
            'service_id'   => Service::where('name', 'Tour Package')->first()->id,
            'package_name' => $this->faker->sentence(3),
            'destination'  => $this->faker->city,
            'fee'       => $this->faker->randomFloat(2, 500, 10000),
            'itinerary'    => $this->faker->paragraph(),
            'start_date'   => $this->faker->dateTimeBetween('+1 week', '+2 weeks'),
            'end_date'     => $this->faker->dateTimeBetween('+2 weeks', '+1 month'),
        ];
    }
}
