<?php

namespace Database\Seeders;

use Database\Seeders\Test\ArticleSeeder;
use Database\Seeders\Test\PageSeeder;
use Database\Seeders\Test\ServiceSeeder;
use Database\Seeders\Test\UserSeeder;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(ArticleSeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(PageSeeder::class);
    }
}
