<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Str;

class CommunicationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        // Example: Seed 50 communication entries
        for ($i = 1; $i <= 50; $i++) {
            DB::table('communications')->insert([
                'sender_id' => $faker->numberBetween(1, 10), // Assuming users have IDs between 1 and 10
                'receiver_id' => $faker->numberBetween(1, 10),
                'project_id' => $faker->boolean(70) ? $faker->numberBetween(1, 5) : null, // 70% chance of linking to a project
                'message' => $faker->sentence(20),
                'attachment' => $faker->boolean(30) ? $faker->imageUrl() : null, // 30% chance of having an attachment
                'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
                'updated_at' => now(),
            ]);
        }
    }
}
