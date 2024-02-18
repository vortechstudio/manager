<?php

namespace Database\Seeders;

use App\Models\Social\Article;
use App\Models\User\User;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Administrateur',
            'email' => 'admin@admin.com',
            'admin' => true,
        ]);

        User::factory(10)->create();
        Article::factory(20)->create();
    }
}
