<?php

namespace Database\Seeders;

use Database\Seeders\production\ServiceSeeder;
use Illuminate\Database\Seeder;

class ProductionSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(ServiceSeeder::class);
    }
}
