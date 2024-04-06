<?php

namespace Database\Seeders;

use App\Models\Config\Service;
use App\Models\Social\Article;
use App\Models\User\User;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Administrateur',
            'email' => 'admin@admin.com',
            'admin' => true,
        ]);

        User::factory(10)->create();
        Article::factory(20)->create();
        $service = Service::create([
            'name' => 'Railway Manager',
            'type' => 'jeux',
            'description' => 'Simulation de compagnie ferroviaire !',
            'page_content' => 'Jeux de simulation de compagnie ferroviaire !',
            'status' => 'idea',
            'url' => '//dev.railway-manager.io',
        ]);

        $service->versions()->create([
            'version' => '0.0.1-alpha',
            'title' => 'Version 0.0.1-alpha',
            'description' => 'Première version alpha du jeu',
            'contenue' => 'Contenue de la version 0.0.1-alpha',
            'published' => true,
            'published_at' => now(),
            'publish_social' => true,
            'publish_social_at' => now(),
            'service_id' => $service->id,
        ]);
        \Storage::makeDirectory("services/$service->id");
    }
}
