<?php

namespace Database\Seeders\staging;

use App\Models\Config\Service;
use App\Models\Social\Cercle;
use App\Models\User\User;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $c_ab = Cercle::create([
            'name' => 'Vortech Studio',
        ]);
        \Storage::makeDirectory("cercles/$c_ab->id");

        $ab = Service::create([
            'name' => 'Accès de Base',
            'type' => 'plateforme',
            'description' => 'Accès au système de vortech studio',
            'page_content' => 'Accès au système de vortech studio',
            'status' => 'production',
            'url' => '//account.vortechstudio.ovh',
            'repository' => 'account_v2',
            'folder' => '/www/wwwroot/account.vortechstudio.ovh',
            'cercle_id' => 1,
        ]);
        \Storage::makeDirectory("services/$ab->id");

        foreach (User::all() as $user) {
            $user->services()->create([
                'status' => true,
                'user_id' => $user->id,
                'service_id' => $ab->id,
                'created_at' => now(),
                'updated_at' => now(),
                'premium' => false,
            ]);

            $user->logs()->create([
                'action' => 'Affiliation au service: Accès de base',
                'user_id' => $user->id,
            ]);
        }

        //---------------------------------------------------------//

        $c_rw = Cercle::create([
            'name' => 'Railway Manager',
        ]);
        \Storage::makeDirectory("cercles/$c_rw->id");

        $rw = Service::create([
            'name' => 'Railway Manager',
            'type' => 'jeux',
            'description' => 'Simulation de compagnie ferroviaire !',
            'page_content' => 'Jeux de simulation de compagnie ferroviaire !',
            'status' => 'idea',
            'url' => '//beta.railway-manager.ovh',
            'repository' => 'railway_manager',
            'folder' => '/www/wwwroot/beta.railway-manager.ovh',
            'cercle_id' => 2
        ]);
        \Storage::makeDirectory("services/$rw->id");

        foreach (User::all() as $user) {
            $user->services()->create([
                'status' => true,
                'user_id' => $user->id,
                'service_id' => $rw->id,
                'created_at' => now(),
                'updated_at' => now(),
                'premium' => false,
            ]);

            $user->logs()->create([
                'action' => 'Affiliation au service: Railway Manager',
                'user_id' => $user->id,
            ]);
        }

        $rw->shops()->create([
            'service_id' => $rw->id,
        ]);
    }
}
