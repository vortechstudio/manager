<?php

namespace Database\Seeders;

use Database\Seeders\staging\ServiceSeeder;
use Database\Seeders\Test\UserSeeder;
use Illuminate\Database\Seeder;

class StagingSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(ServiceSeeder::class);
    }
}
