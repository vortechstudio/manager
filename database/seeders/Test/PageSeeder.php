<?php

namespace Database\Seeders\Test;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Pharaonic\Laravel\Pages\Models\Page;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create('fr_FR');
        $p1 = Page::create(['published' => $faker->boolean]);
        $p1->translateOrNew('fr')->title = $faker->sentence();
        $p1->translateOrNew('fr')->content = $faker->randomHtml();
        $p1->translateOrNew('fr')->description = $faker->sentence();
        $p1->save();

        $p1 = Page::create(['published' => $faker->boolean]);
        $p1->translateOrNew('fr')->title = $faker->sentence();
        $p1->translateOrNew('fr')->content = $faker->randomHtml();
        $p1->translateOrNew('fr')->description = $faker->sentence();
        $p1->save();

        $p1 = Page::create(['published' => $faker->boolean]);
        $p1->translateOrNew('fr')->title = $faker->sentence();
        $p1->translateOrNew('fr')->content = $faker->randomHtml();
        $p1->translateOrNew('fr')->description = $faker->sentence();
        $p1->save();
    }
}
