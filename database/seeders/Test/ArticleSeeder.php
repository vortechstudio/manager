<?php

namespace Database\Seeders\Test;

use App\Models\Social\Article;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        Article::factory(20)->create();
    }
}
