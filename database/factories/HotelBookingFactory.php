<?php

namespace Database\Factories;

use App\Models\HotelBooking;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HotelBooking>
 */
class HotelBookingFactory extends Factory
{
    protected $model = HotelBooking::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $checkInDate = $this->faker->dateTimeBetween('+1 days', '+1 month');
        $checkOutDate = (clone $checkInDate)->modify('+' . rand(1, 7) . ' days');

        // Attempt to find the 'Hotel Booking' service, or create it if it doesn't exist
        $service = Service::firstOrCreate(
            ['name' => 'Hotel Booking'],
            [
                'service_type' => 'hotel_booking',
                'description' => 'Description for Hotel Booking',
                'service_detail_type' => HotelBooking::class,
                'service_detail_id' => 0, // Placeholder, will be updated after creation
            ]
        );

        return [
            'service_id' => $service->id,
            'hotel_name' => $this->faker->company,
            'location' => $this->faker->city,
            'check_in_date' => $checkInDate,
            'check_out_date' => $checkOutDate,
            'num_guests' => $this->faker->numberBetween(1, 4),
            'fee' => $this->faker->randomFloat(2, 100, 1000),
        ];
    }
}
