<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Enums\Config\ServiceStatusEnum;
use App\Enums\Config\ServiceTypeEnum;
use App\Models\Config\Service;
use App\Models\Social\Cercle;
use Database\Seeders\Railway\SettingsSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Cercle::create([
            'name' => 'Vortech Studio',
        ]);
        Cercle::create([
            'name' => 'Vortech Lab',
        ]);
        Cercle::create([
            'name' => 'Railway Manager',
        ]);

        $s = Service::create([
            'name' => 'Accès de base',
            'type' => ServiceTypeEnum::PLATEFORME,
            'description' => 'Accès de base au plateforme Vortech Studio',
            'status' => ServiceStatusEnum::PRODUCTION,
            'url' => '//account.'.config('app.domain'),
            'cercle_id' => 1,
        ]);

        $s->versions()->create([
            'title' => 'Version 1.0.0',
            'description' => 'Première version',
            'contenue' => 'Contenue de la version 1.0.0',
            'published' => true,
            'publish_social' => true,
            'published_at' => now(),
            'publish_social_at' => now(),
            'version' => '1.0.0',
            'service_id' => $s->id,
        ]);

        $this->call(MenuSeeder::class);
        $this->call(SettingsSeeder::class);

        if (config('app.env') == 'local' || config('app.env') == 'testing') {
            $this->call(TestSeeder::class);
        }
    }
}
