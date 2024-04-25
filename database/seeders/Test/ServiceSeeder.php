<?php

namespace Database\Seeders\Test;

use App\Models\Config\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
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
