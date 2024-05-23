<?php

namespace Database\Seeders\production;

use App\Models\Config\Service;
use App\Models\Social\Cercle;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $ab = Service::create([
            'name' => 'Accès de Base',
            'type' => 'plateforme',
            'description' => 'Accès au système de vortech studio',
            'page_content' => 'Accès au système de vortech studio',
            'status' => 'production',
            'url' => '//account.vortechstudio.fr',
            'repository' => 'account_v2',
            'folder' => '/www/wwwroot/account.vortechstudio.fr',
        ]);
        \Storage::makeDirectory("services/$ab->id");

        $c_ab = Cercle::create([
            'name' => 'Vortech Studio',
        ]);
        \Storage::makeDirectory("cercles/$c_ab->id");

        //---------------------------------------------------------//

        $rw = Service::create([
            'name' => 'Railway Manager',
            'type' => 'jeux',
            'description' => 'Simulation de compagnie ferroviaire !',
            'page_content' => 'Jeux de simulation de compagnie ferroviaire !',
            'status' => 'idea',
            'url' => '//stable.vortechstudio.fr',
            'repository' => 'railway_manager',
            'folder' => '/www/wwwroot/stable.railway-manager.fr',
        ]);
        \Storage::makeDirectory("services/$rw->id");

        $c_rw = Cercle::create([
            'name' => 'Railway Manager',
        ]);
        \Storage::makeDirectory("cercles/$c_rw->id");
        $rw->shop()->create([
            'service_id' => $rw->id,
        ]);
    }
}
