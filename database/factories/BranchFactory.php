<?php

namespace Database\Factories;

use App\Models\Branch;
use Illuminate\Database\Eloquent\Factories\Factory;

class BranchFactory extends Factory
{
    protected $model = Branch::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Define a list of branches with their locations
        $branches = [
            ['name' => 'SM Manila Branch', 'location' => 'Manila, Philippines'],
            ['name' => 'SM Legaspi Branch', 'location' => 'Legaspi, Philippines'],
            ['name' => 'SM Daet Branch', 'location' => 'Daet, Philippines'],
            ['name' => 'Naga Branch', 'location' => 'Naga, Philippines'],
        ];

        // Use randomElement to select a branch
        $branch = $this->faker->unique()->randomElement($branches);

        return [
            'name'     => $branch['name'],
            'location' => $branch['location'],
        ];
    }
}
