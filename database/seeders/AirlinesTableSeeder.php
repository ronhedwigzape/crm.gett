<?php

namespace Database\Seeders;

use App\Models\Airline;
use Illuminate\Database\Seeder;

class AirlinesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $airlines = [
            [
                'name' => 'Philippine Airlines (PAL)',
                'code' => 'PR',
                'founded' => 1941,
                'hubs' => 'Manila, Cebu, Clark, Davao',
                'notes' => 'Philippine Airlines is the flag carrier of the Philippines and is the oldest commercial airline in Asia. It operates a mix of domestic and international routes and has a subsidiary, PAL Express, which mainly handles regional flights.',
            ],
            [
                'name' => 'Cebu Pacific',
                'code' => '5J',
                'founded' => 1988,
                'hubs' => 'Manila, Cebu, Clark, Davao, Iloilo',
                'notes' => 'Cebu Pacific is a low-cost airline that dominates the domestic market with a significant market share. It offers both domestic and international flights.',
            ],
            [
                'name' => 'Philippines AirAsia',
                'code' => 'Z2',
                'founded' => 2010,
                'hubs' => 'Manila',
                'notes' => 'Part of the AirAsia Group, this airline offers low-cost flights and competes on several international routes.',
            ],
            [
                'name' => 'Royal Air Philippines',
                'code' => 'RW',
                'founded' => 2002,
                'hubs' => 'Clark',
                'notes' => 'Initially a charter service, Royal Air Philippines now offers regular scheduled services.',
            ],
            [
                'name' => 'AirSWIFT',
                'code' => 'T6',
                'founded' => 2002,
                'hubs' => 'Manila, El Nido',
                'notes' => 'Known for its flights to popular tourist destinations like El Nido.',
            ],
            [
                'name' => 'Cebgo',
                'code' => 'DG',
                'founded' => 1995,
                'hubs' => 'Cebu, Manila',
                'notes' => 'Operates as a subsidiary of Cebu Pacific, focusing on regional routes.',
            ],
            [
                'name' => 'PAL Express',
                'code' => '2P',
                'founded' => 1995,
                'hubs' => 'Manila, Cebu, Clark, Davao, Zamboanga',
                'notes' => 'Operates under Philippine Airlines, serving both domestic and some international routes.',
            ],
            [
                'name' => 'Air Link International Airways',
                'code' => 'AL',
                'founded' => 1983,
                'hubs' => 'Manila',
                'notes' => 'Charter airline.',
            ],
            [
                'name' => 'SEAir International',
                'code' => 'SI',
                'founded' => 2012,
                'hubs' => 'Clark, Manila',
                'notes' => 'Operates as a charter and cargo airline.',
            ],
            [
                'name' => 'MET Express Air Corp.',
                'code' => 'ME',
                'founded' => 2021,
                'hubs' => 'Clark',
                'notes' => 'Cargo airline.',
            ],
            [
                'name' => 'PSI Air 2007',
                'code' => 'PA',
                'founded' => 2016,
                'hubs' => 'Clark',
                'notes' => 'Cargo airline.',
            ],
        ];

        foreach ($airlines as $airline) {
            Airline::updateOrCreate(
                ['name' => $airline['name']],
                [
                    'code' => $airline['code'],
                    'founded' => $airline['founded'],
                    'hubs' => $airline['hubs'],
                    'notes' => $airline['notes'],
                ]
            );
        }
    }
}
