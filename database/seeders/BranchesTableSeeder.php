<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $branches = [
            ['id' => 1, 'name' => 'SM Manila Branch', 'location' => 'Manila, Philippines'],
            ['id' => 2, 'name' => 'SM Legaspi Branch', 'location' => 'Legaspi, Philippines'],
            ['id' => 3, 'name' => 'SM Daet Branch', 'location' => 'Daet, Philippines'],
            ['id' => 4, 'name' => 'Naga Branch', 'location' => 'Naga, Philippines'],
        ];

        foreach ($branches as $branch) {
            Branch::firstOrCreate(['name' => $branch['name']], $branch);
        }
    }
}
