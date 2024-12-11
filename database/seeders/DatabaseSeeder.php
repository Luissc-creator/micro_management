<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserClientOperatorSeeder::class);
        $this->call(ProjectSeeder::class);
        $this->call(ProjectBriefingSeeder::class);
        $this->call(CommunicationsSeeder::class);
    }
}
