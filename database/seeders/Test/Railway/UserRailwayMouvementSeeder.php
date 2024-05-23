<?php

namespace Database\Seeders\Test\Railway;

use App\Models\User\Railway\UserRailwayMouvement;
use Illuminate\Database\Seeder;

class UserRailwayMouvementSeeder extends Seeder
{
    public function run(): void
    {
        UserRailwayMouvement::factory(rand(5, 50))->create();
    }
}
