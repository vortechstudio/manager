<?php

namespace Database\Seeders;

use App\Models\Social\Cercle;
use Database\Seeders\Test\AchievementSeeder;
use Database\Seeders\Test\ArticleSeeder;
use Database\Seeders\Test\PageSeeder;
use Database\Seeders\Test\Railway\EngineSeeder;
use Database\Seeders\Test\ServiceSeeder;
use Database\Seeders\Test\ShopSeeder;
use Database\Seeders\Test\UserSeeder;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    public function run(): void
    {
        $c_ab = Cercle::create([
            'name' => 'Vortech Studio',
        ]);
        $c_ab = Cercle::create([
            'name' => 'Railway Manager',
        ]);
        $this->call(UserSeeder::class);
        $this->call(ArticleSeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(PageSeeder::class);
        $this->call(ShopSeeder::class);
        $this->call(EngineSeeder::class);
    }
}
