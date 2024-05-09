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
        $ab = Service::create([
            'name' => 'Accès de Base',
            'type' => 'plateforme',
            'description' => 'Accès au système de vortech studio',
            'page_content' => 'Accès au système de vortech studio',
            'status' => 'production',
            'url' => '//account.vortechstudio.ovh',
            'repository' => 'account_v2',
            'folder' => '/www/wwwroot/account.vortechstudio.ovh',
        ]);
        \Storage::makeDirectory("services/$ab->id");

        $c_ab = Cercle::create([
            'name' => 'Vortech Studio',
        ]);
        \Storage::makeDirectory("cercles/$c_ab->id");

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

        $rw = Service::create([
            'name' => 'Railway Manager',
            'type' => 'jeux',
            'description' => 'Simulation de compagnie ferroviaire !',
            'page_content' => 'Jeux de simulation de compagnie ferroviaire !',
            'status' => 'idea',
            'url' => '//beta.railway-manager.ovh',
            'repository' => 'railway_manager',
            'folder' => '/www/wwwroot/beta.railway-manager.ovh',
        ]);
        \Storage::makeDirectory("services/$rw->id");

        $c_rw = Cercle::create([
            'name' => 'Railway Manager',
        ]);
        \Storage::makeDirectory("cercles/$c_rw->id");

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
    }
}
