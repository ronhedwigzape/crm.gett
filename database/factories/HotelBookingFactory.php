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

        return [
            'service_id'     => Service::where('service_type', 'hotel_booking')->first()->id,
            'hotel_name'     => $this->faker->company,
            'location'       => $this->faker->city,
            'check_in_date'  => $checkInDate,
            'check_out_date' => $checkOutDate,
            'num_guests'     => $this->faker->numberBetween(1, 4),
            'fee'         => $this->faker->randomFloat(2, 100, 1000),
        ];
    }
}
