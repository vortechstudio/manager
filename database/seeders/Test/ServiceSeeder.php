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
            'repository' => 'railway_manager',
        ]);
        \Storage::makeDirectory("services/$service->id");
    }
}
