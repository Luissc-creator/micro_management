<?php

// database/seeders/UserClientOperatorSeeder.php
namespace Database\Seeders;

use App\Models\User;
use App\Models\Client;
use App\Models\Operator;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UserClientOperatorSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        User::create([
            'name' => 'admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('admin'),
            'role' => 'admin'
        ]);
        // Create users
        for ($i = 0; $i < 10; $i++) {
            $user = User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('password123'),
                'role' => 'operator',
            ]);

            Operator::create([
                'user_id' => $user->id,  // Reference to User
                // Add any other operator-specific data here
            ]);
        }
        for ($i = 0; $i < 10; $i++) {
            $user = User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('password123'),
                'role' => 'client',
            ]);

            Client::create([
                'user_id' => $user->id,  // Reference to User
                // Add any other client-specific data here
            ]);
        }
    }
}
