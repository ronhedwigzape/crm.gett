<?php

namespace Database\Factories;

use App\Models\TourPackage;
use App\Models\Service;
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
        // Attempt to find the 'Tour Package' service, or create it if it doesn't exist
        $service = Service::firstOrCreate(
            ['name' => 'Tour Package'],
            [
                'service_type' => 'tour_package',
                'description' => 'Description for Tour Package',
                'service_detail_type' => TourPackage::class,
                'service_detail_id' => 0, // Placeholder, will be updated after creation
            ]
        );

        return [
            'service_id' => $service->id,
            'package_name' => $this->faker->sentence(3),
            'destination' => $this->faker->city,
            'fee' => $this->faker->randomFloat(2, 500, 10000),
            'itinerary' => $this->faker->paragraph(),
            'start_date' => $this->faker->dateTimeBetween('+1 week', '+2 weeks'),
            'end_date' => $this->faker->dateTimeBetween('+2 weeks', '+1 month'),
        ];
    }
}
