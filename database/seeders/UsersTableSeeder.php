<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure that branches exist
        $branches = Branch::pluck('id')->toArray();

        // Create an admin user
        User::factory()->admin()->create([
            'name'       => 'Admin User',
            'email'      => 'admin@example.com',
            'password'   => Hash::make('password'),
            'branch_id'  => $branches[array_rand($branches)],
        ]);

        // Create two agent users
        User::factory()->create([
            'name'       => 'Agent User One',
            'email'      => 'agent1@example.com',
            'password'   => Hash::make('password'),
            'branch_id'  => $branches[array_rand($branches)],
            'role'       => 'agent',
        ]);

        User::factory()->create([
            'name'       => 'Agent User Two',
            'email'      => 'agent2@example.com',
            'password'   => Hash::make('password'),
            'branch_id'  => $branches[array_rand($branches)],
            'role'       => 'agent',
        ]);
    }
}
